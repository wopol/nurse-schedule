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
        domConstruct.destroy('nurse-schedule-hello');

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
                    minutes: 0,
                    duration: 1000
                },
                minHours: 0,
                maxHours: 24,
                hourSize: 15,
                minColumnWidth: -1,
                horizontalRenderer: HorizontalRenderer,
                verticalRenderer: VerticalRenderer
            },
            style: "position:relative;width:100%;height:490px"
        }, "nurseCalendar");
    }
});
</script>
<div id="nurse-schedule-back">
    <div class="nurse-schedule-overlay">
        <div class="container">
            <div id="nurse-schedule-container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Gratulacje, nowy grafik został poprawnie wygenerowany!</h2>
                    </div>
                    <div class="col-lg-12">
                        <label for="nurse-select">Wybierz pielęgniarkę, której grafik chcesz zobaczyć:</label>
                        <select onchange="changeNurse(this.value);" class="form-control" name="nurse-select" id="nurse-select">
                            <option value="">Wybierz...</option>
                            {foreach $schedule as $nurse}
                                <option value="{$nurse['nurse']['nurse_id']}">Pielęgniarka {$nurse['nurse']['nurse_id']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <h3 id="nurse-schedule-hello">Wybierz pielęgniarkę, aby wyświetlić grafik!</h3>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-lg-12" id="nurseCalendarContainer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
