<?php
namespace Formapro\Pvm;

use function Makasim\Values\get_value;
use function Makasim\Values\set_value;
use Makasim\Values\ValuesTrait;

class TokenTransition
{
    const SCHEMA = 'http://pvm.forma-pro.com/schemas/TokenTransition.json';

    use ValuesTrait {
        setValue as public;
        getValue as public;
    }
    use CreateTrait;

    const STATE_OPENED = 'opened';
    const STATE_PASSED = 'passed';
    const STATE_WAITING = 'waiting';
    const STATE_INTERRUPTED = 'interrupted';

    /**
     * @var Process
     */
    private $_process;

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        set_value($this, 'id', $id);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return get_value($this, 'id');
    }

    /**
     * @return Process
     */
    public function getProcess(): Process
    {
        return $this->_process;
    }

    /**
     * @param Process $process
     */
    public function setProcess(Process $process): void
    {
        $this->_process = $process;
    }

    public function getTransition(): Transition
    {
        return $this->getProcess()->getTransition($this->getId());
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return get_value($this, 'weight');
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        set_value($this, 'weight', $weight);
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return get_value($this, 'state');
    }

    public function setPassed(): void
    {
        $this->setState(self::STATE_PASSED);
    }

    public function isPassed(): bool
    {
        return $this->getState() === self::STATE_PASSED;
    }

    public function setInterrupted(): void
    {
        $this->setState(self::STATE_INTERRUPTED);
    }

    public function isInterrupted(): bool
    {
        return $this->getState() === self::STATE_INTERRUPTED;
    }

    public function setWaiting(): void
    {
        $this->setState(self::STATE_WAITING);
    }

    public function isWaiting(): bool
    {
        return $this->getState() === self::STATE_WAITING;
    }

    public function setOpened(): void
    {
        $this->setState(self::STATE_OPENED);
    }

    public function isOpened(): bool
    {
        return $this->getState() === self::STATE_OPENED;
    }

    public function setTime(int $time): void
    {
        set_value($this, 'time', $time);
    }

    public function getTime(): int
    {
        return get_value($this, 'time');
    }

    private function setState($state): void
    {
        set_value($this, 'state', $state);
    }

    public static function createFor(Transition $transition, int $weight): TokenTransition
    {
        $tokenTransition = static::create();
        $tokenTransition->setId($transition->getId());
        $tokenTransition->setWeight($weight);
        $tokenTransition->setOpened();
        $tokenTransition->setTime((int) (microtime(true) * 10000));

        return $tokenTransition;
    }
}