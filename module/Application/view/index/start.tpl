<style type="text/css">
  .dojoxCalendar{ font-size: 12px; font-family:Myriad,Helvetica,Tahoma,Arial,clean,sans-serif; }
</style>

<script>
require(["dojo/parser", "dojo/ready", "dojox/calendar/Calendar", "dojo/store/Observable", "dojo/store/Memory", "dojox/calendar/ColumnView",
        'dojox/calendar/HorizontalRenderer',
        'dojox/calendar/LabelRenderer',
        'dojox/calendar/VerticalRenderer',
        'dojo/dom',
        'dijit/registry',
        'dojo/dom-construct'],
  function(parser, ready, Calendar, Observable, Memory, ColumnView, HorizontalRenderer, LabelRenderer, VerticalRenderer, dom, registry, domConstruct){
     var schedule = JSON.parse('{$scheduleJson}');

    ready(function(){
        console.log(schedule);
    });

    changeNurse = function(nurseId) {

        if (registry.byId('nurseCalendar')) {
            registry.byId('nurseCalendar').destroyRecursive();
        }
        var container = domConstruct.toDom("<div id='nurseCalendar'></div>");
        domConstruct.place(container, "nurseCalendarContainer");

        calendar = new Calendar({
            date: new Date(2016, 0, 10),
            store: new Observable(new Memory({ data: schedule[nurseId].shifts })),
            dateInterval: "week",
            decodeDate: function(s) {
                    return new Date(s);
            },
            columnViewProps: {
                startTimeOfDay: {
                    hours: 8,
                    minutes: 0
                },
                minHours: 0,
                maxHours: 24,
                hourSize: 20,
                horizontalRenderer: HorizontalRenderer,
                verticalRenderer: VerticalRenderer
            },
            style: "position:relative;width:90%;height:800px"
        }, "nurseCalendar");
    }
});

</script>
    <div>Wybierz pielęgniarkę:
        <select onchange="changeNurse(this.value);">
            <option value="">Wybierz...</option>
            {foreach $schedule as $nurse}
                <option value="{$nurse['nurse']['nurse_id']}">Pielęgniarka {$nurse['nurse']['nurse_id']}</option>
            {/foreach}
        </select>
    </div>
    <div id="nurseCalendarContainer">

    </div>
<br/>



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
