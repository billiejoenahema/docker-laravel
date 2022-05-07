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
        ];
    }

    /**
     * 並び替えるカラムを返します。
     *
     * @return String
     */
    public function getColumn()
    {
        $sortValue = $this->input('sort');
        // 2文字目以降をカラムとして抽出する
        $column = substr($sortValue, 1);
        return $column;
    }

    /**
     * 並び替えの方向を返します。
     *
     * @return String
     */
    public function getOrder()
    {
        $sortValue = $this->input('sort');
        // 1文字目が+なら昇順、そうでなければ降順
        $order = substr($sortValue, 0, 1) === '+' ? 'asc' : 'desc';
        return $order;
    }
}
