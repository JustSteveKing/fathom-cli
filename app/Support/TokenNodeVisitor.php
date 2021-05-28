<?php

declare(strict_types=1);

namespace App\Support;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class TokenNodeVisitor extends NodeVisitorAbstract
{
    protected string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Expr\ArrayItem && $node->key && $node->key->value === 'token') {
            $node->value->value = $this->token;

            return $node;
        }
    }
}
