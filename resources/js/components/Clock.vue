<template>
    <div>
        <template v-if="showClock">
            <AnalogClock  :time="timestamp" size="130px" color="rgba(255,255,255,.53)" bg="transparent"/>
            <p>
                <button class="btn mt-2" :class="color" @click="changeColor">
                    {{ nowDate }}
                </button>
            </p>
        </template>
       <p v-else class="mt-2">
            <button class="btn mt-2" :class="color" @click="changeColor">
                {{ timestamp }} <br>
                {{ nowDate }}
            </button>
       </p>
    </div>
</template>

<script>
    import AnalogClock from 'vue-clock2';

    export default {
        components: {
            AnalogClock
        },
        props:{
            showClock: {
                type: Boolean,
                default: true
            },
        },
        data() {
            return {
                color: localStorage.getItem('clockColor'),
                timestamp: null
            }
        },
        mounted() {
            setInterval(this.getNow, 1000);
            if (!localStorage.getItem('clockColor')) {
                localStorage.setItem('clockColor', 'btn-info');
            }
        },
        computed: {
            nowDate(){
                let today = new Date();
                var week = new Array('Sun', 'Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat');
                var month = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec");
                var day  = week[today.getDay()];
                var daysInMonth  = month[today.getMonth()];
                var dd   = today.getDate();
                var mm   = today.getMonth()+1;
                var yyyy = today.getFullYear();

                if(dd<10)  { dd='0'+dd }
                if(mm<10)  { mm='0'+mm }

                return day+' - '+dd+' '+daysInMonth+', '+yyyy;
            }
        },
        methods: {
            getNow() {
                const today = new Date();
                // const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                const dateTime = time;
                this.timestamp = dateTime;
            },
            changeColor(){
                let colors = ['btn-success','btn-light','btn-dark','btn-danger','btn-warning','btn-info','btn-primary','btn-secondary'];

                let selectedColor = colors[Math.floor(Math.random() * colors.length)];
                this.color = selectedColor;

                localStorage.setItem('clockColor', selectedColor);
            }
        }
    }
</script>
