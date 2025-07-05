import React from 'react';
import testimonialData from '../../data/testimonial/Testimonial.json';
// import Swiper core and required modules
import Link from 'next/link';
import SwiperCore, {Autoplay, Navigation} from "swiper";
import {Swiper, SwiperSlide} from "swiper/react";

SwiperCore.use([Navigation, Autoplay]);

function Testimonial() {
    const testimonialSlider = {
        slidesPerView: "auto",
        speed: 1000,
        spaceBetween: 24,
        loop: true,
        roundLengths: true,
        navigation: {
            nextEl: '.testi-prev1',
            prevEl: '.testi-next1',
        },

        breakpoints: {
            280: {
                slidesPerView: 1
            },
            480: {
                slidesPerView: 1,
                autoplay: true,
            },
            768: {
                slidesPerView: 1
            },
            992: {
                slidesPerView: 2
            },
            1200: {
                slidesPerView: 3
            },

        }
    }
    return (
        <div className="testimonial-section pt-80 pb-80">
            <img alt="image" src="/assets/images/bg/client-right.png" className="client-right-vector"/>
            <img alt="image" src="/assets/images/bg/client-left.png" className="client-left-vector"/>
            <img alt="image" src="/assets/images/bg/clent-circle1.png" className="client-circle1"/>
            <img alt="image" src="/assets/images/bg/clent-circle2.png" className="client-circle2"/>
            <img alt="image" src="/assets/images/bg/clent-circle3.png" className="client-circle3"/>
            <div className="container">
                <div className="row d-flex justify-content-center">
                    <div className="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                        <div className="section-title">
                            <h2>What Client Say</h2>
                            <p className="mb-0">Explore on the world&apos;s best &amp; largest Bidding marketplace with
                                our beautiful Bidding
                                products. We want to be a part of your smile, success and future growth.</p>
                        </div>
                    </div>
                </div>
                <div className="row justify-content-center position-relative">
                    <Swiper {...testimonialSlider} className="swiper testimonial-slider">
                        <div className="swiper-wrapper">
                            {
                                testimonialData.map((data) => {
                                    const {id, description, image, name, designation} = data;
                                    return (
                                        <SwiperSlide key={id} className="swiper-slide">
                                            <div className="testimonial-single hover-border wow fadeInDown"
                                                 data-wow-duration="1.5s" data-wow-delay=".2s">
                                                <img alt="image" src="/assets/images/icons/quote-green.svg"
                                                     className="quote-icon"/>
                                                <div className="testi-img">
                                                    <img alt="image" src={image}/>
                                                </div>
                                                <div className="testi-content">
                                                    <p className="para">{description}</p>
                                                    <div className="testi-designation">
                                                        <h5><Link href="/blog"><a>{name}</a></Link></h5>
                                                        <p>{designation}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </SwiperSlide>
                                    )
                                })
                            }
                        </div>
                    </Swiper>
                    <div className="slider-arrows testimonial2-arrow d-flex justify-content-between gap-3">
                        <div className="testi-prev1 swiper-prev-arrow" tabIndex={0} role="button"
                             aria-label="Previous slide"><i className="bi bi-arrow-left"/></div>
                        <div className="testi-next1 swiper-next-arrow" tabIndex={0} role="button"
                             aria-label="Next slide">
                            <i className="bi bi-arrow-right"/></div>
                    </div>
                </div>
            </div>
        </div>


    )
}

export default Testimonial