<?php

namespace Sem\Weben\Http;

class Response implements ResponseInterface {

    public function json($payload): void {
        echo json_encode($payload);
    }
}