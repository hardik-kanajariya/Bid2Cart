import React, {useState} from "react";
import {toast, ToastContainer} from 'react-toastify';
import Zoom from 'react-reveal/Zoom';

function ContactInfo() {
    const [name, setName] = useState("");
    const [lastname, setLastName] = useState("");
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState("");
    const [subject, setSubject] = useState("");
    const [msg, setMsg] = useState("");

    const handleForm = async (e) => {
        e.preventDefault();

        let headersList = {
            "Accept": "*/*", "Content-Type": "application/json"
        }

        let bodyContent = JSON.stringify({
            "firstname": name,
            "lastname": lastname,
            "mobile": phone,
            "email": email,
            "subject": subject,
            "message": msg,
        });

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/contact`, {
            method: "POST", body: bodyContent, headers: headersList
        });

        let data = await response.json();
        console.log(data);

        if (data['error']) {
            // console.log(data.data['error'])
            let check = data['error'];
            if ('firstname' in check) {
                toast.warning('First name is required')
            } else if ('lastname' in check) {
                toast.warning('Last name is required')
            } else if ('mobile' in check) {
                toast.warning('Mobile number is required')
            } else if ('email' in check) {
                toast.warning('Email is required')
            } else if ('subject' in check) {
                toast.warning('Subject is required')
            } else if ('message' in check) {
                toast.warning('Message is required')
            } else {
                toast.warning('Something went wrong please try again after sometime')
            }
        }

        // User registered successfully 
        if (data['status'] === true) {
            toast.success(`Thanks for reaching out to us. We appreciate your interest in our business. This is to confirm that we’ve successfully received your request for ${subject}.`);
        }
    }

    return (<div className="contact-section pt-120 pb-120">
            <ToastContainer/>
            <img alt="image" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-top"/>
            <img alt="image" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-bottom"/>
            <div className="container">
                <div className="row pb-120 mb-70 g-4 d-flex justify-content-center">
                    <div className="col-lg-4 col-md-6 col-sm-8">
                        <Zoom cascade top>
                            <div
                                className="contact-signle hover-border d-flex flex-row align-items-center wow fadeInDown"
                                data-wow-duration="1.5s" data-wow-delay=".2s">
                                <div className="icon">
                                    <i className="bi bi-geo-alt"/>
                                </div>
                                <div className="text">
                                    <h4>Location</h4>
                                    <p>{process.env.NEXT_PUBLIC_CONTACT_ADDRESS_LINE1}, {process.env.NEXT_PUBLIC_CONTACT_ADDRESS_LINE2}, {process.env.NEXT_PUBLIC_CONTACT_ADDRESS_AREA_CODE}, {process.env.NEXT_PUBLIC_CONTACT_ADDRESS_COUNTRY}</p>
                                </div>
                            </div>
                        </Zoom>
                    </div>
                    <div className="col-lg-4 col-md-6 col-sm-8">
                        <Zoom cascade top>
                            <div
                                className="contact-signle hover-border d-flex flex-row align-items-center wow fadeInDown"
                                data-wow-duration="1.5s" data-wow-delay=".4s">
                                <div className="icon">
                                    <i className="bx bx-phone-call"/>
                                </div>
                                <div className="text">
                                    <h4>Phone</h4>
                                    <div className='d-flex flex-column  justify-center'>
                                        <a href={`tel:${process.env.NEXT_PUBLIC_CONTACT_PHONE}`}>{process.env.NEXT_PUBLIC_CONTACT_PHONE}</a>
                                        <a href={`tel:${process.env.NEXT_PUBLIC_CONTACT_PHONE2}`}>{process.env.NEXT_PUBLIC_CONTACT_PHONE2}</a>
                                    </div>
                                </div>
                            </div>
                        </Zoom>
                    </div>
                    <div className="col-lg-4 col-md-6 col-sm-8">
                        <Zoom cascade top>
                            <div
                                className="contact-signle hover-border d-flex flex-row align-items-center wow fadeInDown"
                                data-wow-duration="1.5s" data-wow-delay=".6s">
                                <div className="icon">
                                    <i className="bx bx-envelope"/>
                                </div>
                                <div className="text">
                                    <h4>Email</h4>
                                    <div className='d-flex flex-column  justify-center'>
                                        <a href={`mailto:${process.env.NEXT_PUBLIC_CONTACT_EMAIL}`}>{process.env.NEXT_PUBLIC_CONTACT_EMAIL}</a>
                                        <a href={`mailto:${process.env.NEXT_PUBLIC_CONTACT_EMAIL2}`}>{process.env.NEXT_PUBLIC_CONTACT_EMAIL2}</a>
                                    </div>
                                </div>
                            </div>
                        </Zoom>
                    </div>
                </div>
                <div className="row g-4">
                    <div className="col-lg-6">
                        <div className="form-wrapper wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div className="form-title2">
                                <h3>Get in Touch</h3>
                                <p className="para">Feel free to ask me any question </p>
                            </div>
                            <form action="#">
                                <div className="row">
                                    <Zoom cascade>
                                        <div className="col-xl-6 col-lg-12 col-md-6">
                                            <div className="form-inner">
                                                <input type="text" placeholder="Your First Name :" value={name}
                                                       onChange={(event) => {
                                                           setName(event.target.value)
                                                       }}/>
                                            </div>
                                        </div>
                                        <div className="col-xl-6 col-lg-12 col-md-6">
                                            <div className="form-inner">
                                                <input type="text" placeholder="Your Last Name :" value={lastname}
                                                       onChange={(event) => {
                                                           setLastName(event.target.value)
                                                       }}/>
                                            </div>
                                        </div>
                                        <div className="col-xl-6 col-lg-12 col-md-6">
                                            <div className="form-inner">
                                                <input type="email" placeholder="Your Email :" value={email}
                                                       onChange={(e) => {
                                                           setEmail(e.target.value)
                                                       }}/>
                                            </div>
                                        </div>
                                        <div className="col-xl-6 col-lg-12 col-md-6">
                                            <div className="form-inner">
                                                <input type="text" placeholder="Your Phone :" value={phone}
                                                       onChange={(e) => {
                                                           setPhone(e.target.value)
                                                       }}/>
                                            </div>
                                        </div>
                                        <div className="col-xl-6 col-lg-12 col-md-6">
                                            <div className="form-inner">
                                                <input type="text" placeholder="Subject :" value={subject}
                                                       onChange={(e) => {
                                                           setSubject(e.target.value)
                                                       }}/>
                                            </div>
                                        </div>
                                        <div className="col-12">
                                            <textarea name="message" placeholder="Write Message :" rows={12} value={msg}
                                                      onChange={(e) => {
                                                          setMsg(e.target.value)
                                                      }}/>
                                        </div>
                                        <div className="col-12">
                                            <button onClick={handleForm}
                                                    className="eg-btn btn--primary btn--md form--btn">Send Message
                                            </button>
                                        </div>
                                    </Zoom>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div className="col-lg-6">
                        <div className="map-area wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".4s">
                            <Zoom right>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6255252.31904332!2d-106.08810052683293!3d40.04590513383155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sbd!4v1650355365902!5m2!1sen!2sbd"
                                    style={{border: 0}} allowFullScreen loading="lazy"
                                    referrerPolicy="no-referrer-when-downgrade"/>
                            </Zoom>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    )
}

export default ContactInfo