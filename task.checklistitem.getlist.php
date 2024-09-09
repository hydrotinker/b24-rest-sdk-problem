<?php

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;

//Был на версии 1.2.2 - метод работал корректно
$taskId = 10941;
$this->client->addBatchCall("task.checklistitem.getlist", ["TASKID" => $taskId], function ($response) use (&$rows, $taskId) {
    foreach ($response['result'] as $row) {
        $rows[$taskId][] = $row;
    }
});

//Перешел на версию 2.0 - пробую:
try {
    $response = $this->core->call("task.checklistitem.getlist", [
        "TASKID" => 10941
    ]);
    $response = $this->core->call("task.checklistitem.getlist", [
        "taskid" => 10941
    ]);
    $response = $this->core->call("task.checklistitem.getlist", [
        "taskId" => 10941
    ]);
    $response = $this->core->call("task.checklistitem.getlist", [
        "TaskId" => 10941
    ]);
    $response = $this->core->call("task.checklistitem.getlist", [10941]);
    dd($response->getResponseData()->getResult());

    $response2 = $this->batch->getTraversableList("task.checklistitem.getlist",[],["TASKID" => 10941],[],null,[]);
    $response2 = $this->batch->getTraversableList("task.checklistitem.getlist",[],["taskid" => 10941],[],null,[]);
    $response2 = $this->batch->getTraversableList("task.checklistitem.getlist",[],["taskId" => 10941],[],null,[]);
    $response2 = $this->batch->getTraversableList("task.checklistitem.getlist",[],["TaskId" => 10941],[],null,[]);
    $response2 = $this->batch->getTraversableList("task.checklistitem.getlist",[],[10941],[],null,[]);
    $response2 = $this->batch->getTraversableList("task.checklistitem.getlist",[],[],[],null,[10941]);
    dd($response2->current());
} catch (TransportException|BaseException $e) {
    dd($e->getMessage());
    //Все варианты отдают следующий текст:
    //"error_core - tasks_error_exception_#256; param #0 (taskid) for method ctaskchecklistitem::getlist() expected to be of type "integer", but given something else.; 256/te/wrong_arguments<br> "
}