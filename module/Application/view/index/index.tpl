
{foreach $nurses as $nurse}
    {$nurse->id()}:
    {foreach $nurse->getShifts() as $shift}
        {$shift->getDay()->getDayNumber()}{$shift->getType()}{if $shift->getDay()->isWeekend()}*{/if} ,
    {/foreach}
    <br/>
    <br/>
{/foreach}
<br/>
