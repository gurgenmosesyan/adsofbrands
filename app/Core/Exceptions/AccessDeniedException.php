<?php

namespace App\Core\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AccessDeniedException extends HttpException {}