<?php

declare(strict_types=1);

namespace PhpLlm\LlmChain\Tests\Chain\StructuredOutput;

use PhpLlm\LlmChain\Chain\StructuredOutput\SchemaFactory;
use PhpLlm\LlmChain\Tests\Fixture\StructuredOutput\MathReasoning;
use PhpLlm\LlmChain\Tests\Fixture\StructuredOutput\Step;
use PhpLlm\LlmChain\Tests\Fixture\StructuredOutput\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaFactory::class)]
final class SchemaFactoryTest extends TestCase
{
    private SchemaFactory $schemaFactory;

    protected function setUp(): void
    {
        $this->schemaFactory = new SchemaFactory();
    }

    #[Test]
    public function buildSchemaForUserClass(): void
    {
        $expected = [
            'title' => 'User',
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
                'name' => [
                    'type' => 'string',
                    'description' => 'The name of the user in lowercase',
                ],
                'createdAt' => [
                    'type' => 'string',
                    'format' => 'date-time',
                ],
                'isActive' => ['type' => 'boolean'],
                'age' => ['type' => ['integer', 'null']],
            ],
            'required' => ['id', 'name', 'createdAt', 'isActive'],
            'additionalProperties' => false,
        ];

        $actual = $this->schemaFactory->buildSchema(User::class);

        self::assertSame($expected, $actual);
    }

    #[Test]
    public function buildSchemaForMathReasoningClass(): void
    {
        $expected = [
            'title' => 'MathReasoning',
            'type' => 'object',
            'properties' => [
                'steps' => [
                    'type' => 'array',
                    'items' => [
                        'title' => 'Step',
                        'type' => 'object',
                        'properties' => [
                            'explanation' => ['type' => 'string'],
                            'output' => ['type' => 'string'],
                        ],
                        'required' => ['explanation', 'output'],
                        'additionalProperties' => false,
                    ],
                ],
                'finalAnswer' => ['type' => 'string'],
            ],
            'required' => ['steps', 'finalAnswer'],
            'additionalProperties' => false,
        ];

        $actual = $this->schemaFactory->buildSchema(MathReasoning::class);

        self::assertSame($expected, $actual);
    }

    #[Test]
    public function buildSchemaForStepClass(): void
    {
        $expected = [
            'title' => 'Step',
            'type' => 'object',
            'properties' => [
                'explanation' => ['type' => 'string'],
                'output' => ['type' => 'string'],
            ],
            'required' => ['explanation', 'output'],
            'additionalProperties' => false,
        ];

        $actual = $this->schemaFactory->buildSchema(Step::class);

        self::assertSame($expected, $actual);
    }
}
