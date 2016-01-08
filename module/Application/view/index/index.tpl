
{foreach $nurses as $nurse}
    {$nurse->id()}:
    {foreach $nurse->getShifts() as $shift}
        {$shift->getDateString()}
        {$shift->getType()}
        {if $shift->getDay()->isWeekend()}*{/if} ,<br/>
    {/foreach}
    <br/>
    <br/>
{/foreach}
<br/>
