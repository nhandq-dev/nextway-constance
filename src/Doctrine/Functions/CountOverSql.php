<?php

namespace App\Doctrine\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\AST\Node;

/**
 * Class CountOverSql
 */
class CountOverSql extends FunctionNode
{
    public const FUNCTION_NAME = 'COUNT_OVER';

    /**
     * @var Node
     */
    private $field;

    public function getSql(SqlWalker $sqlWalker)
    {
        return "COUNT(" . $this->field->dispatch($sqlWalker) . ") OVER()";
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->field = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
