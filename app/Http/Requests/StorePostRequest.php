<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'title' => ['required','min:3', 'unique:posts,title,'.$this->route('post')],
        'description' => ['required','min:10'],
        'post_creator' => ['required','exists:users,id'],
        'image' => 'nullable|image|mimes:jpg,png|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
                'title.required' => "اكتب هنا متسيبهاش فاضية" ,
                'title.unique' => "الاسم ده حد كتبه قبلك معلش اكتب حاجه تانيه" ,
                'title.min' => "معلش زود شويه .. متكتبش اقل من 3 حروف" ,
                'description.required' => "اكتب هنا متسيبهاش فاضية" ,
                'description.min' => "معلش زود شويه .. متكتبش اقل من 10 حروف" ,
                'post_creator.required' =>  "اكتب هنا متسيبهاش فاضية" ,
                'post_creator.exists' =>  "يا لئيــــــم قفشتك .. متعملش كده تاني بقي" ,
        ];
    }
}

