<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class PublishScheduledArticles implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Récupérer les articles qui sont planifiés et dont la date de publication est passée
        $articlesToPublish = Article::scheduled()->get();

        foreach ($articlesToPublish as $article) {
            // Log pour vérifier si l'article est récupéré
            Log::info("Article à publier : " . $article->title);

            // Si la date de publication est inférieure ou égale à la date actuelle, publier l'article
            if ($article->published_at <= now()) {
                $article->update([
                    'published_at' => now()
                    // mettre à jour la date de publication
                ]);

                Log::info("Article publié : " . $article->title);
            }
        }
    }
}
