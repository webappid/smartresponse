<?php
/**
 * Author: galih
 * Date: 2019-05-19
 * Time: 22:37
 */

namespace WebAppId\SmartResponse\Requests;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 18/04/20
 * Time: 18.55
 * Interface FormRequestContract
 * @package WebAppId\SmartResponse\Requests
 */
interface FormRequestContract
{
    public function authorize(): bool;

    public function rules(): array;

    public function messages(): array;

    public function attributes(): array;
}
