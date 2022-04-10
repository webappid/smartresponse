<?php
/**
 * Author: galih
 * Date: 2019-05-19
 * Time: 22:36
 */

namespace WebAppId\SmartResponse\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 18/04/20
 * Time: 18.55
 * Class AbstractFormRequest
 * @package WebAppId\SmartResponse\Requests
 */
abstract class AbstractFormRequest extends FormRequest implements FormRequestContract
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return mixed
     */
    abstract function rules(): array;

    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }
}
