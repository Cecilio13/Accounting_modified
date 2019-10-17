    var data = [{
        label: 'Apples',
        value: 30,
        color: "#F7464A"
    }, {
        value: 50,
        color: "#E2EAE9"
    }, {
        value: 100,
        color: "#D4CCC5"
    }, {
        value: 40,
        color: "#949FB1"
    }, {
        value: 120,
        color: "#4D5360"
    }

    ]

    var options = {
        animation: true,
        showTooltips: true,
        tooltipFillColor: "rgba(255,255,255,0.7)",
        tooltipFontColor: "#000",
        tooltipEvents: ["mousemove", "touchstart", "touchmove"],
        multiTooltipTemplate: "<%= datasetLabel %>$<%= value %>",
        onAnimationComplete: function()
        {
            this.showTooltip(this.segments, true);
        },
        
        tooltipEvents: [],
        
    };

    //Get the context of the canvas element we want to select
    var c = $('#myChart');
    var ct = c.get(0).getContext('2d');
    var ctx = document.getElementById("myChart").getContext("2d");
    /*************************************************************************/
    myNewChart = new Chart(ct).Doughnut(data, options);


