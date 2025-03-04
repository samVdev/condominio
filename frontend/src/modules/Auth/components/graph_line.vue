<script lang="ts" setup>
import ApexCharts from 'apexcharts';
import { onMounted } from 'vue';


const options = {
series: [
  {
    name: "Detractores",
    data: [0, 1000],
    color: "#EA5165",
  },
  {
    name: "Otros",
    data: [0, 4000],
    color: "#4E85C8",
  },
],
chart: {
  height: "70%",
  type: "area",
  fontFamily: "Inter, sans-serif",
  dropShadow: {
    enabled: false,
  },
  toolbar: {
    show: false,
  },
},
tooltip: {
  enabled: true,
  x: {
    show: false,
  },
},
legend: {
  show: true
},
fill: {
  type: "gradient",
  gradient: {
    opacityFrom: 0.4,
    opacityTo: 0,
    shade: "#1C64F2",
    gradientToColors: ["#1C64F2"],
  },
},
dataLabels: {
  enabled: false,
},
stroke: {
  width: 4,
},
grid: {
  show: true,
  strokeDashArray: 10,
  padding: {
    left: 2,
    right: 2,
    top: 0
  },
},
xaxis: {
  labels: {
    show: false,
  },
},
yaxis: {
  show: false,
},
}



onMounted(() => {
    if (document.getElementById("chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("chart"), options);
        chart.render();
}
})


</script>

<template>
    
    <div class="w-full h-full">
        <div class="flex gap-10 items-center">
            <div v-for="item in options.series">
                <p class="flex gap-2 items-center justify-center">
                    <label
                        class="rounded-full w-[1vh] h-[1vh] border p-2"
                        :style="{ backgroundColor: `${item.color}` }"
                        ></label>
                    {{ item.name }}
                </p>
                <p class="ml-5 text-center text-sm font-medium text-gray-900">0 - {{item.data[1]}}</p>
                </div>
            </div>
        <div id="chart" class="chart"></div>
    </div>

</template>

<style>

#chart, .chart #apexchartsw6lh0zhv, .chart svg, .chart > *, .chart foreignObject, #apexchartsm5c4k4pa svg{
    width: 100%!important;
    height: 100%!important
}
</style>