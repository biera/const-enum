<?php

namespace spec\Biera;

use PhpSpec\ObjectBehavior;

class ConstEnumSpec extends ObjectBehavior
{
    function it_fails_to_initliaze_itself_when_no_scalar_consts_found()
    {
        $this->beAnInstanceOf('spec\Biera\InvalidEnum');
        $this->beConstructedThrough('create', [0]);

        $this->shouldThrow()->duringInstantiation();
    }

    function it_fails_to_initliaze_itself_when_invalid_parameter_provided()
    {
        $this->beAnInstanceOf('spec\Biera\Enum');
        $this->beConstructedThrough('create', [0]);

        $this->shouldThrow()->duringInstantiation();
    }

    function it_initliaze_itself_when_valid_parameter_provided()
    {
        $this->beAnInstanceOf('spec\Biera\Enum');
        $this->beConstructedThrough('create', [Enum::OPTION_A]);

        $this->value()->shouldBe(Enum::OPTION_A);
    }

    function it_is_a_value_object()
    {
        $this->beAnInstanceOf('spec\Biera\Enum');
        $this->beConstructedThrough('create', [Enum::OPTION_A]);

        $this->equals(Enum::create(Enum::OPTION_A))->shouldBe(true);
        $this->equals(Enum::create(Enum::OPTION_B))->shouldBe(false);
    }
}

class InvalidEnum extends \Biera\ConstEnum
{
    const OPTION_A = [];
}

class Enum extends \Biera\ConstEnum
{
    const OPTION_A = 'A';
    const OPTION_B = 'B';
    const OPTION_C = 'C';
}