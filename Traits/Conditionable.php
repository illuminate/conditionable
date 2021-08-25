<?php

namespace Illuminate\Support\Traits;

use Closure;
use Illuminate\Support\HigherOrderWhenProxy;

trait Conditionable
{
    /**
     * Apply the callback if the given "value" is (or resolves to) truthy.
     *
     * @param mixed $value
     * @param callable|null $callback
     * @param callable|null $default
     * @return $this|mixed
     */
    public function when(mixed $value, callable $callback = null, callable $default = null): HigherOrderWhenProxy|static
    {
        $value = $value instanceof Closure ? $value($this) : $value;

        if (!$callback) {
            return new HigherOrderWhenProxy($this, $value);
        }

        if ($value || $default) {
            $callableMethod = $value ? $callback : $default;
            return $callableMethod($this, $value) ?: $this;
        }

        return $this;
    }

    /**
     * Apply the callback if the given "value" is (or resolves to) falsy.
     *
     * @param mixed $value
     * @param callable|null $callback
     * @param callable|null $default
     * @return $this|null
     */
    public function unless(mixed $value, callable $callback = null, callable $default = null): HigherOrderWhenProxy|static
    {
        $value = $value instanceof Closure ? $value($this) : $value;

        if (!$callback) {
            return new HigherOrderWhenProxy($this, !$value);
        }

        if (!$value || $default) {
            $callableMethod = !$value ? $callback : $default;
            return $callableMethod($this, $value) ?: $this;
        }

        return $this;
    }
}
