import Link from "next/link"
import React, {useEffect, useState} from "react";
import Layout from "../components/layout/Layout";
import {toast, ToastContainer} from 'react-toastify';
import Router from "next/router";
import Preloader from "../components/common/Preloader";

function ForgotPassword() {
    const [isLoaded, setIsLoaded] = useState(true)
    const [email, setEmail] = useState('');

    useEffect(() => {
        // If user is logged in can not access this page 
        if (sessionStorage.getItem('token')) {
            Router.push('/dashboard')
        }
        setIsLoaded(false)
    }, [])

    // Sending response to server to send password reset mail to given email address 
    const SendPasswordResetMail = async (e) => {
        e.preventDefault();
        // `${process.env.NEXT_PUBLIC_API_URL}/api/auth/reset/password?email=MoonBabe@mail.com`
        // Sending Password Reset Email 
        let headersList = {
            "Accept": "application/json"
        }

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/auth/reset/password?email=${email}`, {
            method: "GET", headers: headersList
        });

        let data = await response.json();
        console.log(data);
        if (data.status === true) {
            toast.info(data.msg)
        } else {
            toast.error(data.msg)
        }
    }
    return (<>
            {isLoaded ? (<Preloader classText="preloader"/>) : (<Layout>
                {/* <Breadcrumb pageName="Log In" pageTitle="Log In" /> */}
                <ToastContainer/>
                <div className="login-section pt-120 pb-120">
                    <img alt="imges" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-top"/>
                    <img alt="imges" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-bottom"/>
                    <div className="container">
                        <div className="row d-flex justify-content-center g-4">
                            <div className="col-xl-6 col-lg-8 col-md-10">
                                <div className="form-wrapper wow fadeInUp" data-wow-duration="1.5s"
                                     data-wow-delay=".2s">
                                    <div className="form-title">
                                        <h3>Forgot Password</h3>
                                        <p> Remember your Password?{" "}
                                            <Link href="/login">
                                                <a>Login here</a>
                                            </Link>
                                        </p>
                                    </div>
                                    <form className="w-100" onSubmit={SendPasswordResetMail}>
                                        <div className="row">
                                            <div className="col-12">
                                                <div className="form-inner">
                                                    <label>Enter Your Email *</label>
                                                    <input type="email" placeholder="Enter Your Email"
                                                           onChange={(event) => {
                                                               setEmail(event.target.value)
                                                           }} value={email} required={true}/>
                                                </div>
                                            </div>
                                        </div>
                                        <button className="account-btn">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Layout>)}
        </>);
}

export default ForgotPassword