<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user(); // <-- tambahkan ini
        $userId = $user->id;

        $query = Quiz::with(['user', 'soals'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        $showAll = $request->get('show_all', false);
        $categories = Kategori::all();

        if (! $showAll) {
            $allQuizzes = $query->get();
            $quizzes = $allQuizzes;
        } else {
            $quizzes = $query->paginate(12);
        }

        return view('backend.index', compact('quizzes', 'showAll', 'categories', 'user'));
    }

    public function indexAlternative(Request $request)
    {
        $userId = Auth::user()->id;
        $showAll = $request->get('show_all', false);

        $allQuizzes = Quiz::with(['user', 'soals'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($showAll) {
            $quizzes = Quiz::with(['user', 'soals'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            $categories = Kategori::all();

            return view('backend.all', compact('quizzes', 'allQuizzes', 'categories'));
        } else {
            $quizzes = $allQuizzes->where('created_at', '>=', now()->subDays(7));
            $categories = Kategori::all();

            return view('backend.index', compact('quizzes', 'allQuizzes', 'categories'));
        }
    }
}
