<?php

namespace App\Concerns;

trait SendsAlerts
{
    protected function success(string $id = null, $parameters = [])
    {
        $this->sendAlert('success', $id, $parameters);
    }

    protected function error(string $id = null, $parameters = [])
    {
        $this->sendAlert('error', $id, $parameters);
    }

    private function sendAlert(string $type, string $id = null, $parameters = [])
    {
        session([$type => trans($id, (array) $parameters)]);
    }
}
