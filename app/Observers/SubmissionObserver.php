<?php

namespace App\Observers;

use App\Models\Submission;

class SubmissionObserver
{
    public function creating(Submission $submission)
    {
        $word = $submission->word;
        $submission->score = strlen($word);
    }
}
