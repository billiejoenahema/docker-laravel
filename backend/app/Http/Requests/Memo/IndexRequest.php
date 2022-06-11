<?php

namespace App\Http\Requests\Memo;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'tag_ids' => 'nullable|array',
            'search_word' => 'nullable|string',
            'sort' => 'nullable|string',
        ];
    }

    /**
     * 並び替えるカラムを返します。
     *
     * @return String
     */
    public function getSortColumn()
    {
        if ($this->input('sort')) {
            $sortValue = $this->input('sort');
            // 2文字目以降をカラムとして抽出する
            $column = substr($sortValue, 1);
            return $column;
        }
        return 'created_at';
    }

    /**
     * 並び替えの方向を返します。
     *
     * @return String
     */
    public function getSortOrder()
    {
         if ($this->input('sort')) {
             $sortValue = $this->input('sort');
             // 1文字目が+なら昇順、そうでなければ降順
             $order = substr($sortValue, 0, 1) === '+' ? 'asc' : 'desc';
             return $order;
         }
         return 'desc';
    }
}
