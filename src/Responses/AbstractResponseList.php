<?php
/**
 * Author: galih
 * Date: 2019-05-19
 * Time: 22:33
 */

namespace WebAppId\SmartResponse\Responses;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 26/04/20
 * Time: 13.49
 * Class AbstractResponse
 * @package WebAppId\SmartResponse\Responses
 */
abstract class AbstractResponseList
{
    /**
     * @var bool
     */
    public $status;
    /**
     * @var string
     */
    public $message;

    /**
     * @var int
     */
    public $count;

    /**
     * @var int
     */
    public $countFiltered;
}
