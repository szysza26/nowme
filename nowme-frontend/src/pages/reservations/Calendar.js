import React, {useState, useEffect} from 'react';
import BigCalendar from 'react-big-calendar-like-google';
import moment from 'moment';
import 'react-big-calendar-like-google/lib/css/react-big-calendar.css';
import axios from "axios";

BigCalendar.momentLocalizer(moment);

const Calendar = props => {

    const [myEventList, setMyEventList] = useState([]);

    useEffect(() => {
        let tmp = props.reservations.map(event => {
            let d = event.reservation_date.substring(8, 10)
            let m = event.reservation_date.substring(5, 7)
            let y = event.reservation_date.substring(0, 4)
            return {
                startDate: moment().format(y + " " + m + " " + d),
                endDate: moment().format(y + " " + m + " " + d)
            }
        })
        setMyEventList(tmp);

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [props.reservations])

    return(
        <div>
            <BigCalendar
                events={myEventList}
                startAccessor='startDate'
                endAccessor='endDate'
            />
        </div>
    )
}

export default Calendar;