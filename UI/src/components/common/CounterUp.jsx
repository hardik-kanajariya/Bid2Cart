import {useRouter} from 'next/router';
import React from 'react';
import CountUp from "react-countup";
import Zoom from 'react-reveal/Zoom';

function CounterUp() {
    const router = useRouter()
    const currentRouter = router.pathname
    return (
        <div className={currentRouter === "/about" ? "about-us-counter pb-120 pt-120" : "about-us-counter pb-120"}>
            <div className="container">
                <div className="row g-4 d-flex justify-content-center">
                    <Zoom top cascade>
                        <div className="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                            <div
                                className={`counter-single text-center d-flex flex-row ${currentRouter === "/" ? "hover-border" : currentRouter === "/index2" ? "hover-border2" : currentRouter === "/index3" ? "hover-border" : "hover-border"} wow animate fadeInDown`}
                                data-wow-duration="1.5s" data-wow-delay="0.2s">
                                <div className="counter-icon"><img alt="image" src="/assets/images/icons/employee.svg"/>
                                </div>
                                <div className="coundown d-flex flex-column">
                                    <h3 className="odometer" data-odometer-final={5400}><CountUp end={210} delay={2}
                                                                                                 duration={5}/></h3>
                                    <p>Happy Customer</p>
                                </div>
                            </div>
                        </div>
                        <div className="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                            <div
                                className={`counter-single text-center d-flex flex-row ${currentRouter === "/" ? "hover-border" : currentRouter === "/index2" ? "hover-border2" : currentRouter === "/index3" ? "hover-border" : "hover-border"} wow animate fadeInDown`}
                                data-wow-duration="1.5s" data-wow-delay="0.2s">
                                <div className="counter-icon"><img alt="image" src="/assets/images/icons/review.svg"/>
                                </div>
                                <div className="coundown d-flex flex-column">
                                    <h3 className="odometer" data-odometer-final={1250}><CountUp end={250} delay={2}
                                                                                                 duration={5}/></h3>
                                    <p>Good Reviews</p>
                                </div>
                            </div>
                        </div>
                        <div className="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                            <div
                                className={`counter-single text-center d-flex flex-row ${currentRouter === "/" ? "hover-border" : currentRouter === "/index2" ? "hover-border2" : currentRouter === "/index3" ? "hover-border" : "hover-border"} wow animate fadeInDown`}
                                data-wow-duration="1.5s" data-wow-delay="0.2s">
                                <div className="counter-icon"><img alt="image" src="/assets/images/icons/smily.svg"/>
                                </div>
                                <div className="coundown d-flex flex-column">
                                    <h3 className="odometer" data-odometer-final={4250}><CountUp end={150} delay={2}
                                                                                                 duration={5}/></h3>
                                    <p>Winner Customer</p>
                                </div>
                            </div>
                        </div>
                        <div className="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                            <div
                                className={`counter-single text-center d-flex flex-row ${currentRouter === "/" ? "hover-border" : currentRouter === "/index2" ? "hover-border2" : currentRouter === "/index3" ? "hover-border" : "hover-border"} wow animate fadeInDown`}
                                data-wow-duration="1.5s" data-wow-delay="0.2s">
                                <div className="counter-icon"><img alt="image" src="/assets/images/icons/comment.svg"/>
                                </div>
                                <div className="coundown d-flex flex-column">
                                    <h3 className="odometer" data-odometer-final={500}><CountUp end={550} delay={2}
                                                                                                duration={5}/></h3>
                                    <p>New Comments</p>
                                </div>
                            </div>
                        </div>
                    </Zoom>
                </div>
            </div>
        </div>

    )
}

export default CounterUp