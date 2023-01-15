<template>
    <table class="table table-bordered">
        <thead style="background-color:#f0f0f0">
            <tr height="50px" class="align-middle text-center">
                <th width="125" class="fz-15 text-dark font-weight-bold">{{ $t("time") }}/{{ $t("day") }}</th>
                <th v-for="(day,index) in weekDays" :key="index" class="fz-15 text-dark font-weight-bold">{{ day }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(days,time) in calendarData" :key="time">
                <td>
                    <h4><b>{{ time }}</b></h4>
                </td>
                <td v-for="(value,index) in days" :key="index" v-if="arrayCheck(value)"
                    :rowspan="value['rowspan']" class="align-middle text-center p-2"
                    style="background-color:#f0f0f0">
                    <span v-tooltip="'Subject Name'" :class="backgroundColor(value['subject'])" class="box-shadow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white fz-14">
                        {{ value['subject'] }}
                    </span>
                    <div class="margin-10px-top fz-15" v-tooltip="'Class (Section)'" v-if="authenticateUser.original_role == 'Teacher'">
                        <b>{{ value['class_name'] }}({{ value['section'] }})</b>
                    </div>
                    <div class="fz-15 mt-2" v-tooltip="'Room No'">
                        <b>{{ value['room_no'] }}</b>
                    </div>
                    <div class="fz-12" v-if="authenticateUser.original_role != 'Teacher'" v-tooltip="'Teacher Name'">
                        <b>{{ value['teacher_name'] }}</b>
                    </div>
                    <div class="fz-13" v-tooltip="'Duration'">
                        <b>({{ value['time'] }})</b>
                    </div>
                </td>
                <template v-else-if="value == 1">
                    <td></td>
                </template>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        calendarData: {
            type: Object | Array,
            default: {}
        },
        weekDays: {
            type: Object | Array,
            default: {},
        }
    },
    methods:{
        arrayCheck(value){
            var type = typeof value;

            if (type === 'object') {
                return true;
            }else{
                return false;
            }
        },
        backgroundColor(subject){
            switch (subject) {
                case 'Bangla':
                    return 'bg-sky';
                    break;
                case 'English':
                    return 'bg-orange';
                    break;
                case 'Math':
                    return 'bg-green';
                    break;
                case 'Science':
                    return 'bg-yellow';
                    break;
                case 'Social':
                    return 'bg-pink';
                    break;
                case 'Religion':
                    return 'bg-purple';
                    break;
                case 'ICT':
                    return 'bg-sky';
                    break;
                case 'Art':
                    return 'bg-orange';
                    break;
                case 'Music':
                    return 'bg-yellow';
                    break;
                case 'Dance':
                    return 'bg-pink';
                    break;
                case 'Drawing':
                    return 'bg-purple';
                    break;
                default:
                    return 'bg-lightred';
            }
        }
    }
}
</script>

<style scoped>
body{
    margin-top:20px;
}
.bg-light-gray {
    background-color: #f7f7f7;
}
.bg-sky.box-shadow {
    box-shadow: 0px 5px 0px 0px #00a2a7
}

.bg-orange.box-shadow {
    box-shadow: 0px 5px 0px 0px #af4305
}

.bg-green.box-shadow {
    box-shadow: 0px 5px 0px 0px #4ca520
}

.bg-yellow.box-shadow {
    box-shadow: 0px 5px 0px 0px #dcbf02
}

.bg-pink.box-shadow {
    box-shadow: 0px 5px 0px 0px #e82d8b
}

.bg-purple.box-shadow {
    box-shadow: 0px 5px 0px 0px #8343e8
}

.bg-lightred.box-shadow {
    box-shadow: 0px 5px 0px 0px #d84213
}


.bg-sky {
    background-color: #02c2c7
}

.bg-orange {
    background-color: #e95601
}

.bg-green {
    background-color: #5bbd2a
}

.bg-yellow {
    background-color: #f0d001
}

.bg-pink {
    background-color: #ff48a4
}

.bg-purple {
    background-color: #9d60ff
}

.bg-lightred {
    background-color: #ff5722
}

.padding-15px-lr {
    padding-left: 15px;
    padding-right: 15px;
}
.padding-5px-tb {
    padding-top: 5px;
    padding-bottom: 5px;
}
.margin-10px-bottom {
    margin-bottom: 10px;
}
.border-radius-5 {
    border-radius: 5px;
}

.margin-10px-top {
    margin-top: 10px;
}
</style>
