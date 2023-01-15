<?php

namespace App\Http\Controllers\Api\Admin;

use App\Actions\LanguageList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class LanguageController extends Controller
{
    /**
     * Display a language listing.
     */
    public function index()
    {
        $filesArray = LanguageList::fileList();

        return response()->json($filesArray);
    }

    /**
     * Get a language file content.
     */
    public function show($locale)
    {
        $path = base_path("/resources/js/locales/{$locale}.json");

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $content = file_get_contents($path);

        return response()->json(json_decode($content, true));
    }

    /**
     * Create a language file and put default json contents
     *
     * @param \Illuminate\Http\Request $request
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string|max:15',
        ]);

        $languageArray = $request->languages;

        if (in_array($request->code, $languageArray)) {
            return response()->json([
                'errors' => [
                    'code' => 'Language code already exists'
                ]
            ], 422);
        } else {
            $fileName = Str::slug($request->code, '_');
            $filePath = base_path('resources/js/locales/' . $fileName . '.json');
            $translations = $request->translations;
            $jsonTranslations = json_encode($translations, JSON_UNESCAPED_UNICODE);

            try {
                $fp = fopen($filePath, 'w');
                fwrite($fp, $jsonTranslations);
                fclose($fp);

                return responseSuccess('code', $fileName, 'success');
            } catch (\Throwable $th) {
                return responseError('failed', 500);
            }
        }

        $filesArray = LanguageList::fileList();
        return response()->json($filesArray);
    }

    /**
     * Create a language file and put default json contents
     *
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request)
    {
        try {
            $filePath = base_path('resources/js/locales/' . $request->code . '.json');

            $data = file_get_contents($filePath);
            $translations = json_decode($data, true);
            $requestTranslations = $request->translations;


            foreach ($translations as $key => $value) {
                if ($requestTranslations[$key]) {
                    $translations[$key] = $requestTranslations[$key];
                } else {
                    $translations[$key] = "";
                }
            }
            file_put_contents($filePath, json_encode($translations, JSON_UNESCAPED_UNICODE));

            return responseSuccess('', '', 'success');
        } catch (\Throwable $th) {
            return responseError('failed', 500);
        }
    }
}
