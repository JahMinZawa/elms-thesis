<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function showScore(Request $request)
    {
        // Retrieve all submitted answers
        $answers = $request->input('answers', []);
        $activityId = $request->activityId;
        $activity = Activity::find($activityId);

        // Now you can process the answers as needed
        $score = 0;
        $maxScore = 0;

        if ($activity->type == 'Quiz') {
            foreach ($activity->questions as $question) {
                $correctAns = "";
                $index = $question->id;

                // Retrieve the user's answer for this question, if available
                $userAnswer = $answers[$index] ?? null;

                // Retrieve the correct answer for this question
                foreach ($question->choices as $choice) {
                    if ($choice->is_correct) {
                        $correctAns = $choice->choice;
                        break;
                    }
                }

                // Check if the user provided an answer for this question
                if ($userAnswer !== null && $userAnswer == $correctAns) {
                    $score += $question->points;
                }

                $maxScore += $question->points;
            }
        } elseif ($activity->type == "Fill in the blanks") {
            foreach ($activity->questions as $index => $question) {
                // Get the choices for the current question
                $choices = $question->choices->pluck('choice')->toArray();

                // Get the user's answers for the current question, if available
                $userAnswers = $answers[$index] ?? [];

                // Check each user answer against the corresponding choice
                foreach ($userAnswers as $index1 => $userAnswer) {
                    // Check if the user's answer is not empty and matches the correct choice for this blank
                    if (!empty($userAnswer) && $userAnswer == $choices[$index1]) {
                        // Increase the score if the answer is correct
                        $score += ($question->points / count($choices));
                    }
                }

                // Increment the maximum score
                $maxScore += $question->points;
            }
        }

        $user = Auth::user();
        $attempts = $activity->count_attempts($user->id) + 1;
        $user->attempts()->attach($user, [
            'activity_id' => $activity->id,
            'attempts' => $attempts,
            'score' => $score,
            'maxScore' => $maxScore
        ]);

        $this->updateCoins();
        return redirect('/activity/' . $activity->id);
    }


    public function updateCoins(){
        $user = Auth::user();
        $coins = $user->coins;
        $activities = $user->activities;

        foreach ($activities as $activity) {
            // Get the pivot record for the current user and activity
            $pivot = $activity->pivot;

            // Skip this activity if coins have already been awarded
            if ($pivot->coins_awarded) {
                continue;
            }

            //kung ilan points ni user yun yung madadagdag sa coins
            $pivot->coins_awarded = true;
            $pivot->save();

            if($activity->count_attempts($user->id) <= 1){
                $coins+=$activity->score($user->id);
            }


        }

        // Update the user's coins in the database
        $user->coins = $coins * 10;
        $user->save();
    }


    public function submitFile(Request $request)
    {
        $activityId = $request->activityId;
        $activity = Activity::find($activityId);

        // Validate the file upload
        $request->validate([
            'fileInput' => 'required|file', // Add additional validation rules as needed
        ]);

        // Retrieve the file object from the request
        $file = $request->file('fileInput');

        // Get the original filename
        $originalFilename = $file->getClientOriginalName();

        // Store the file with its original name
        $activityFilePath = $file->storeAs('uploads', $originalFilename, 'public');

        // Extract the filename from the file path (optional, since you already have the original name)
        $activityFileName = basename($activityFilePath);

        $user = Auth::user();
        $attempts = $activity->count_attempts($user->id) + 1;

        // Attach the activity data to the user
        $user->attempts()->attach($user, [
            'activity_id' => $activity->id,
            'attempts' => $attempts,
            'score' => 0,
            'maxScore' => 0,
            'file' => $activityFileName, // Use the original filename
        ]);

        return redirect('/activity/' . $activityId);
    }

    public function deductCoins(Request $request){
        $user = Auth::user();

        // Check if user has sufficient coins
        if ($user->coins >= 100) {
            // Deduct coins only if user has sufficient balance
            $user->coins -= 100;
            $user->save();

            $activity = Activity::find($request->activityId);
            if ($activity) {
                // Your existing redirection logic here
                $redirectUrl = '';
                switch ($activity->type) {
                    case 'Quiz':
                        $redirectUrl = "/quiz/{$activity->id}";
                        break;
                    case 'Fill in the blanks':
                        $redirectUrl = "/fillBlanks/{$activity->id}";
                        break;
                    case 'FileSubmission':
                        $redirectUrl = "/fileSubmit/{$activity->id}";
                        break;
                    default:
                        // Handle default case or invalid activity type
                        break;
                }
                return redirect($redirectUrl);
            } else {
                // Handle activity not found
                return redirect()->back()->with('error', 'Activity not found.');
            }
        } else {
            // Handle insufficient coins
            return redirect()->back()->with('error', 'Insufficient coins.');
        }
    }






}
