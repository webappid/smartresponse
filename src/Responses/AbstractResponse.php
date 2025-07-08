<?php
/**
 * Author: galih
 * Date: 2019-05-19
 * Time: 22:33
 */

namespace WebAppId\SmartResponse\Responses;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 18/04/20
 * Time: 18.55
 * Class AbstractResponse
 * @package WebAppId\SmartResponse\Responses
 */
abstract class AbstractResponse
{
    public bool $status;
    public string $message;
}
