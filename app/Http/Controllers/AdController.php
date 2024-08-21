<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class AdController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::query();

        // Сортировка
        if ($request->has('sort_by')) {
            $direction = $request->get('sort_dir', 'asc');
            $query->orderBy($request->get('sort_by'), $direction);
        }

        // Пагинация
        $ads = $query->paginate(10);

        return response()->json($ads->transform(function($ad) {
            return [
                'title' => $ad->title,
                'main_image' => $ad->images ? json_decode($ad->images)[0] : null,
                'price' => $ad->price,
            ];
        }));
    }

    public function show(Ad $ad, Request $request)
    {
        $response = [
            'title' => $ad->title,
            'price' => $ad->price,
            'main_image' => $ad->images ? json_decode($ad->images)[0] : null,
        ];

        if ($request->has('fields')) {
            $fields = explode(',', $request->get('fields'));
            if (in_array('description', $fields)) {
                $response['description'] = $ad->description;
            }
            if (in_array('images', $fields)) {
                $response['images'] = json_decode($ad->images);
            }
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:3',
            'images.*' => 'url',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $ad = Ad::create([
            'title' => $request->title,
            'description' => $request->description,
            'images' => json_encode($request->images),
            'price' => $request->price,
        ]);

        return response()->json(['id' => $ad->id, 'status' => 'success']);
    }
}
