<?php

namespace App\Http\Requests\Memo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:30',
            'content' => 'nullable|string|max:200',
            'tags' => 'required|array|'
        ];
    }

    /**
     * タグIDの配列を返します。
     *
     * @return array
     */
    public function getTagIds()
    {
        $tags = collect($this->input('tags'));
        $tagIds = $tags->pluck('id');
        return $tagIds;
    }
}
