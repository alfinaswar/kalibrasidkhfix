(function ($) {
    "use strict";

    // MAterial Date picker
    $("#mdate,#mdate2,#mdate3, #mdate4").bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
    });

    $("#timepicker").bootstrapMaterialDatePicker({
        format: "HH:mm",
        time: true,
        date: false,
    });
    $("#date-format, #date-format-new").bootstrapMaterialDatePicker({
        format: "YYYY-MM-DD HH:mm:ss",
    });

    $("#min-date").bootstrapMaterialDatePicker({
        format: "DD/MM/YYYY HH:mm",
        minDate: new Date(),
    });
})(jQuery);
