<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    protected $fillable = [
        'internship_id',
        'date',
        'operations_carried_out',
        'tools_equipment_used',
        'challenges_faced',
        'recommendations',
        'status',
        'flagged_duplicate',
        'similar_to_log_entry_id',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
    public function similarEntry()
    {
        return $this->belongsTo(LogEntry::class, 'similar_to_log_entry_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function isReviewable(): bool
    {
        $fridayOfWeek = \Carbon\Carbon::parse($this->date)
            ->startOfWeek(\Carbon\Carbon::MONDAY)
            ->addDays(4)
            ->startOfDay();

        return now()->startOfDay()->gte($fridayOfWeek);
    }
    public static function checkForDuplicate(int $internshipId, string $text, ?int $excludeId = null): array
    {
        $threshold = 0.8;

        $recentEntries = self::where('internship_id', $internshipId)
            ->when($excludeId, fn ($query) => $query->where('id', '!=', $excludeId))
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get(['id', 'operations_carried_out']);

        $newTokens = self::tokenize($text);

        $bestMatchId = null;
        $bestScore = 0;

        foreach ($recentEntries as $entry) {
            $score = self::jaccardSimilarity($newTokens, self::tokenize($entry->operations_carried_out));

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatchId = $entry->id;
            }
        }

        return [
            'flagged' => $bestScore >= $threshold,
            'similar_to_log_entry_id' => $bestScore >= $threshold ? $bestMatchId : null,
        ];
    }

    protected static function tokenize(string $text): array
    {
        $words = preg_split('/\W+/', strtolower($text), -1, PREG_SPLIT_NO_EMPTY);

        return array_unique($words);
    }

    protected static function jaccardSimilarity(array $a, array $b): float
    {
        if (empty($a) || empty($b)) {
            return 0;
        }

        $intersection = count(array_intersect($a, $b));
        $union = count(array_unique(array_merge($a, $b)));

        return $union > 0 ? $intersection / $union : 0;
    }
}