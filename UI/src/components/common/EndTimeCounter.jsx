import React, {useEffect, useRef, useState} from "react";


function EndTimeCounter({product_id}) {
    const [timerDays, setTimeDays] = useState(0);
    const [timerHours, setTimerHours] = useState(0);
    const [timerMinutes, setTimerMinutes] = useState(0);
    const [timerSecounds, setTimerSecounds] = useState(0);
    let interval = useRef();

    const startTimer = (date) => {
        // console.log("Start timer calling once")
        const countdownDate = new Date(date);
        const interval = setInterval(() => {
            // console.log("calling interval")
            const now = new Date().getTime();
            const distance = countdownDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const secound = Math.floor((distance % (1000 * 60)) / 1000);

            if (distance < 0) {
                clearInterval(interval.current);
            } else {
                setTimeDays(days);
                setTimerHours(hours);
                setTimerMinutes(minutes);
                setTimerSecounds(secound);
            }
        }, 1000);

    };
    useEffect(() => {
        fetchProductData(product_id);

        // Fetch product Data 
        async function fetchProductData(id) {
            const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/products?product_id=${id}`);
            const data = await response.json();
            startTimer(data.end_time);
        }

        return () => {
            // eslint-disable-next-line react-hooks/exhaustive-deps
            clearInterval(interval.current);
        };
        // 
    });

    return <>
        <span id="hours1">{timerDays}</span>D :&nbsp;
        <span id="hours1">{String(timerHours)}</span>H :&nbsp;
        <span id="minutes1">{String(timerMinutes)}</span>M :&nbsp;
        <span id="seconds1">{String(timerSecounds)}</span>S
    </>;
}

export default EndTimeCounter;
