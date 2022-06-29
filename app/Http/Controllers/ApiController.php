<?php

namespace App\Http\Controllers;

use App\Models\LottoApi;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class ApiController extends Controller
{
    public function getByDate(string $date): string
    {
        try {
            $data = LottoApi::where('draw_date', $date)->first();
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $data['id'],
                    'date' => $data['draw_date'],
                    'numbers' => $data['numbers']
                ]
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Draw not exist'
            ]);
        }
    }

    public function getByNumber(int $number): string
    {
        try {
            $draws = LottoApi::where('numbers', 'like', "%$number%")->get();
            $result = [
                'count' => 0,
                'dates' => []
            ];
            foreach ($draws as $draw) {
                $result['count']++;
                $result['dates'][] = $draw['draw_date'];
            }
            return response()->json([
                'success' => true,
                'data' => $result
            ], 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'The number was not drawn'
            ]);
        }
    }
}
