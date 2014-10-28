<?php

use Nam\Commander\DefaultCommandBus;

/**
 * DefaultCommandBusTest Test Case
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 *
 */
class DefaultCommandBusTest extends PHPUnit_Framework_TestCase
{
    public function test_execute_command()
    {
        // prepare
        $command = Mockery::mock('Nam\Commander\BaseCommand');

        $commandValidator = Mockery::mock('Nam\Commander\CommandValidator');
        $commandValidator->shouldReceive('validate')->once()->with($command)->andReturn(true);

        $commandHandler = Mockery::mock('Nam\Commander\CommandHandler');
        $commandHandler->shouldReceive('handle')->once()->with($command)->andReturn('ok');

        $commandInflector = Mockery::mock('Nam\Commander\Inflectors\CommandInflector');
        $commandInflector->shouldReceive('getCommandHandler')->once()->with($command->mockery_getName())->andReturn($commandHandler->mockery_getName());
        $commandInflector->shouldReceive('getCommandValidator')->once()->with($command->mockery_getName())->andReturn($commandHandler->mockery_getName());

        $app = Mockery::mock('Illuminate\Foundation\Application');
        $app->shouldReceive('make')->twice()->andReturn($commandValidator, $commandHandler);

        $commandBus = new DefaultCommandBus($app, $commandInflector);

        // act
        $result = $commandBus->execute($command);

        // assert
        $this->assertEquals('ok', $result);
    }
}
