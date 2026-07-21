document.addEventListener("DOMContentLoaded", function () {

    // Sidebar Toggle
    const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");
const toggle = document.getElementById("toggleSidebar");

if(toggle){

    toggle.addEventListener("click", function(){

        sidebar.classList.toggle("show");

        overlay.classList.toggle("show");

    });

}

overlay.addEventListener("click", function(){

    sidebar.classList.remove("show");

    overlay.classList.remove("show");

});

    // Cashflow Chart
    const chartElement = document.querySelector("#cashflowChart");

    if (chartElement) {

        const options = {

            chart: {
                type: "area",
                height: 350,
                toolbar: {
                    show: false
                }
            },

           series: [{
    name: "Cashflow",
    data: window.cashflowData
}],

            xaxis: {
                categories: [
                    "Jan","Feb","Mar","Apr","May","Jun",
                    "Jul","Aug","Sep","Oct","Nov","Dec"
                ]
            },

            stroke: {
                curve: "smooth",
                width: 3
            },

            dataLabels: {
                enabled: false
            },

            colors: ["#0B1F3A"],

            fill: {
                opacity: 0.2
            }

        };

        new ApexCharts(chartElement, options).render();
    }

});

toggle.addEventListener("click", function(){

    if(window.innerWidth >= 992){

        document.body.classList.toggle("sidebar-collapsed");

    }else{

        sidebar.classList.toggle("show");

        overlay.classList.toggle("show");

    }

});