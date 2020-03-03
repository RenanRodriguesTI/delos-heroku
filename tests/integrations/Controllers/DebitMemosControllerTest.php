<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 08/06/17
 * Time: 10:46
 */

namespace Delos\Dgp\Http\Controllers;


class DebitMemosControllerTest extends \TestCase
{
    public function testShowReport()
    {
        $this->route('GET', 'debitMemos.showReport', ['id' => 10]);
        $this->assertFileExists(base_path() . '/resources/views/debit-memos/debit-memo-details.xlsx');
        $this->assertResponseStatus(302);
    }
}
