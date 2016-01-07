
{foreach $nurses as $nurse}
    {$nurse->id()}:
    {foreach $nurse->getShifts() as $shift}
        {$shift->getDay()->getDayNumber()}{$shift->getType()} ,
    {/foreach}
    <br/>
    <br/>
{/foreach}
<br/>
