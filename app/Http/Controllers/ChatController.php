<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Dataset\ArrayDataset;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;

class ChatController extends Controller
{
    // Menampilkan halaman chat
    public function index()
    {
        $chats = Chat::all();
        return view('chat', compact('chats'));
    }

    // Menyimpan chat baru
    public function store(Request $request): JsonResponse
    {
        // Simpan pesan pengguna
        $chat = new Chat();
        $chat->sender = 'user';
        $chat->message = $request->message;
        $chat->save();

        // Logika respons asisten (dikembangkan di langkah berikutnya)
        $response = $this->generateAssistantResponse($request->message);

        // Simpan balasan asisten
        $assistantChat = new Chat();
        $assistantChat->sender = 'assistant';
        $assistantChat->message = $response;
        $assistantChat->save();

        // Return JSON response
        return response()->json([
            'user_message' => $chat->message,
            'assistant_message' => $assistantChat->message,
        ]);
    }

    private function generateAssistantResponse($message): string
    {
        $message = strtolower($message);

        // Contoh logika respons lebih canggih
        if (strpos($message, 'hello') !== false || strpos($message, 'hi') !== false) {
            return "Hello! How can I assist you today?";
        } elseif (strpos($message, 'time') !== false) {
            return "The current time is " . date('H:i');
        } elseif (strpos($message, 'date') !== false) {
            return "Today's date is " . date('Y-m-d');
        } elseif (strpos($message, 'help') !== false) {
            return "I can assist with general inquiries, time and date information, or other questions you may have.";
        } elseif (strpos($message, 'weather') !== false) {
            return "I can't check the weather right now, but you can try using a weather app or website.";
        } elseif (strpos($message, 'name') !== false) {
            return "You can call me your Virtual Assistant!";
        } elseif (strpos($message, 'who are you') !== false) {
            return "I am a Virtual Assistant created to help you with various tasks.";
        } elseif (strpos($message, 'programming') !== false) {
            return "I can help you with programming-related questions. What do you need assistance with?";
        } elseif (strpos($message, 'joke') !== false) {
            return "Why don't scientists trust atoms? Because they make up everything!";
        } elseif (strpos($message, 'calculate') !== false) {
            return "I can help with simple calculations. Try asking me something like 'What's 2 + 2?'";
        } elseif (strpos($message, 'thank you') !== false || strpos($message, 'thanks') !== false) {
            return "You're welcome! If you have any more questions, feel free to ask.";
        } elseif (strpos($message, 'goodbye') !== false || strpos($message, 'bye') !== false) {
            return "Goodbye! Have a great day!";
        } elseif (strpos($message, 'laravel') !== false) {
            return "Laravel is a powerful PHP framework. How can I assist you with Laravel?";
        } elseif (strpos($message, 'javascript') !== false) {
            return "JavaScript is a versatile programming language. What would you like to know about it?";
        } elseif (strpos($message, 'php') !== false) {
            return "PHP is a popular server-side scripting language. Do you need help with PHP?";
        } elseif (strpos($message, 'css') !== false) {
            return "CSS is used to style web pages. Are you facing any challenges with CSS?";
        } elseif (strpos($message, 'html') !== false) {
            return "HTML is the structure of web pages. How can I assist you with HTML?";
        } elseif (strpos($message, 'recommendation') !== false) {
            return "I can suggest programming languages, frameworks, or tools based on your needs. What are you looking for?";
        } elseif (strpos($message, 'project') !== false) {
            return "Need help with your project? Let me know the details, and I'll try to assist.";
        } elseif (strpos($message, 'database') !== false) {
            return "Databases are crucial for storing data. Are you working with SQL, NoSQL, or something else?";
        } elseif (strpos($message, 'bootstrap') !== false) {
            return "Bootstrap is a great CSS framework for responsive design. What do you need help with?";
        } elseif (strpos($message, 'version control') !== false) {
            return "Version control, like Git, helps manage changes in your code. Do you need help with Git commands?";
        } elseif (strpos($message, 'server') !== false) {
            return "Servers host your applications. Are you setting up a server or troubleshooting one?";
        } elseif (strpos($message, 'debugging') !== false) {
            return "Debugging is essential to find and fix errors. What issue are you facing?";
        } elseif (strpos($message, 'news') !== false) {
            return "I can't provide current news, but you can check a news website or app for the latest updates.";
        } elseif (strpos($message, 'recipe') !== false) {
            return "I can't provide recipes directly, but I can suggest websites or apps where you can find great recipes.";
        } elseif (strpos($message, 'movie') !== false) {
            return "Looking for movie recommendations? I can suggest popular movies or you can check out a movie review site.";
        } elseif (strpos($message, 'music') !== false) {
            return "I can suggest music genres or artists. What type of music are you interested in?";
        } elseif (strpos($message, 'travel') !== false) {
            return "I can't book travel for you, but I can suggest travel tips or destinations based on your preferences.";
        } elseif (strpos($message, 'health') !== false) {
            return "For health-related advice, it's best to consult with a healthcare professional. I can provide general tips if needed.";
        } elseif (strpos($message, 'fitness') !== false) {
            return "Looking for fitness tips? I can suggest workout routines or general fitness advice.";
        } elseif (strpos($message, 'sports') !== false) {
            return "Interested in sports? I can provide general information or suggest where to find the latest sports news.";
        } elseif (strpos($message, 'history') !== false) {
            return "I can provide general historical information or suggest resources where you can learn more about history.";
        } elseif (strpos($message, 'education') !== false) {
            return "Looking for educational resources? I can suggest websites or tools for learning.";
        } elseif (strpos($message, 'technology') !== false) {
            return "Technology is evolving rapidly. What specific technology or topic are you interested in?";
        } else {
            return "I'm not sure I understand your request. Could you please elaborate?";
        }
    }
}
