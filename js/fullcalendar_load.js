/*
fetch fullcalendar events and details
 */

$(document).ready(function () {

    let myLocale = 'fr';
    if (getCookie("siteLanguage") != 1) {
        myLocale = 'gb';
    }
    $('#calendar').fullCalendar({
        header: {left: 'prev,next', center: 'title', right: 'today'},
        themeSystem: 'bootstrap4',
        timeFormat: 'H(:mm)',
        locale: myLocale,
        height: 'auto',
        firstDay: 1,
        navLinks: false, // can click day/week names to navigate views
        editable: false,
        startParam: 'date_from',
        endParam: 'date_to',
        eventSources: [
            {//Events
                url: '../controller/calendar_controller.php',
                type: 'POST',
                data: {action: "listEvents", languageId: getCookie("siteLanguage")},
                color: 'rgb(255,203,5)',
                textColor: 'black',
                error: function () {
                    alert('There was an error while fetching events.');
                }
            },
            {//Locations
                url: '../controller/calendar_controller.php',
                type: 'POST',
                data: {action: "listLocations", languageId: getCookie("siteLanguage")},
                color: 'black',
                textColor: 'white',
                error: function () {
                    alert('There was an error while fetching events.');
                }
            }
        ],

        eventClick: function (event, jsEvent, view) {
            let jsonEnvoye = {action: "detail", eventType: event.type, itemId: event.itemId, languageId: getCookie("siteLanguage")};
            $.post("../controller/calendar_controller.php", jsonEnvoye, function (jsonRecu) {
                console.log(jsonRecu);
                let arr = JSON.parse(jsonRecu);

                $('#eventTitle').html(arr.TITLE);
                $('#eventDescription').html(arr.DESCRIPTION);
                $('#eventAddress').html(arr.ADDRESS);
                $('#eventDateStart').html(arr.DATETIME_START);
                $('#eventDateEnd').html(arr.DATETIME_END);

                if (event.type == 'EVENT') {
                    $('#eventLink').html(arr.LINK);
                    $('#eventLinkLnk').prop("href",arr.LINK);

                    if (arr.IMAGE != '') {
                        // $('#eventImage').show();
                        $('#eventImage').show().attr("src", "data:image/jpeg;base64," + arr.IMAGE);
                    } else {
                        $('#eventImage').hide();
                    }
                    $('#eventEditBtn').click(function () {
                        window.location = "../view/eventEdit.php?id=" + arr.EVEN_ID;
                    });
                } else if (event.type == 'LOCATION') {
                    $('#eventImage').hide();

                    $('#eventEditBtn').click(function () {
                        window.location = "../view/locationEdit.php?id=" + arr.LOCA_ID;
                    });
                }

                //open the modal
                $('#eventModal').modal();

            })
        }
    });
});