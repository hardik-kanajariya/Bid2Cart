import React from 'react'

function FaqForm() {
    return (<div className="col-lg-4 col-md-12 order-lg-1 order-2">
            <div className="faq-form-area wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                <h5>Ask Any Question?</h5>
                <p className="para">Your email address will not be published. Required fields are marked *</p>
                <form className="faq-form">
                    <div className="form-inner">
                        <label>Your Full Name *</label>
                        <input type="text" placeholder="Enter your name"/>
                    </div>
                    <div className="form-inner">
                        <label>Your Email *</label>
                        <input type="text" placeholder="Enter your email"/>
                    </div>
                    <div className="form-inner">
                        <label>Subject *</label>
                        <input type="text" placeholder="Subject"/>
                    </div>
                    <div className="form-inner">
                        <label>Your Message *</label>
                        <textarea placeholder="Your message" rows={5} defaultValue={""}/>
                    </div>
                    <a href="#" className="eg-btn btn--primary btn--md mt-1">Send Now</a>
                </form>
            </div>
        </div>)
}

export default FaqForm