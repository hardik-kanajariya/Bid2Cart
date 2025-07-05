import React, {useEffect, useState} from "react";
import Layout from "../components/layout/Layout";
import Link from "next/link";
import Preloader from "../components/common/Preloader";
import {toast, ToastContainer} from 'react-toastify';
import {GoogleLogin, GoogleOAuthProvider} from '@react-oauth/google';
import jwt_decode from "jwt-decode";
import Router from "next/router";

function SignupPage() {
    const [openEye, setOpenEye] = useState();
    const [firstName, setFirstName] = useState("");
    const [lastName, setLastName] = useState("");
    const [street, setStreet] = useState("");
    const [city, setCity] = useState("");
    const [state, setState] = useState("");
    const [country] = useState("Canada");
    const [zipCode, setZipCode] = useState("");
    const [mobile, setMobile] = useState("");
    const [hereAbout] = useState("N/A");
    const [userName, setUserName] = useState("");
    const [email, setEmail] = useState("");
    const [passWord, setPassword] = useState("");
    const [isLoaded, setIsLoaded] = useState(true)

    useEffect(() => {
        // If user is already logged in
        if (sessionStorage.getItem('token')) {
            Router.push('/dashboard')
        }

        setIsLoaded(false)
    }, [])

    // Custom Sign Up
    const Register = async (e) => {
        // Start Loading
        setIsLoaded(false)
        e.preventDefault();

        // Processing Data validation
        if (firstName === "") {
            toast.error('First Name is required')
            return false;
        } else if (lastName === "") {
            toast.error('Last Name is required')
            return false;
        } else if (userName === "") {
            toast.error('User Name is required')
            return false;

        } else if (email === "") {
            toast.error('Email is required')
            return false;
        } else if (passWord === "") {
            toast.error('Password is required')
            return false;
        }

        // mobile number validation
        if (mobile !== "" && mobile.length < 10) {
            toast.error('Mobile number must be 10 digits')
            return false;
        }


        // Email validation regex
        const re = /\S+@\S+\.\S+/;
        if (!re.test(email)) {
            toast.error('Email is not valid')
            return false;
        }


        // Using Fetch API
        let headersList = {
            "Accept": "*/*", "Content-Type": "application/json"
        }

        let bodyContent = JSON.stringify({
            "firstname": firstName,
            "lastname": lastName,
            "street": street,
            "city": city,
            "state": state,
            "country": country,
            "zipcode": zipCode,
            "phone": mobile,
            "username": userName,
            "email": email,
            "password": passWord,
            "hereabout": hereAbout
        });

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/auth/register`, {
            method: "POST", body: bodyContent, headers: headersList
        });

        let data = await response.json();
        if (data.status === "error") {
            toast.error(data.message)
        } else {
            toast.success('Registration Successful, Please check your mail box to verify your Email :)')
        }

        // Set Loading False
        setIsLoaded(false)
    }


    const handleEyeIcon = () => {
        if (openEye === false || openEye === 0) {
            setOpenEye(1);
        } else {
            setOpenEye(false);
        }
    };

    // Google Authentication
    async function decode(token) {
        let jwt = await jwt_decode("Bearer " + token);
        if (jwt.email) {
            let headersList = {
                "Accept": "*/*", "Content-Type": "application/json"
            }

            let bodyContent = JSON.stringify({
                "firstname": jwt.given_name,
                "lastname": jwt.family_name,
                "username": jwt.given_name + '_' + Math.floor(Math.random() * 99999),
                "email": jwt.email,
                "password": jwt.email,
                "avatar": jwt.picture,
                "social_id": jwt.sub
            });

            let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/auth/social-google`, {
                method: "POST", body: bodyContent, headers: headersList
            });

            let data = await response.json();
            if (data.error) {
                // console.log(data.error);
                if (data.error.email) {
                    toast.error(data.error.email[0])
                } else if (data.error.username) {
                    toast.error(data.error.username[0])
                } else {
                    toast.warning(data.error)
                }

            } else {
                toast.success('Registration Successful, Please check your mail box to verify your Email :)')
            }
        } else {
            toast.warning("Something went wrong please try again after some time...")
        }
        // Using Fetch API

    }

    // Function to validate Mobile
    const validateMobile = (e) => {
        const re = /^[0-9\b]+$/;
        if (e.target.value === '' || re.test(e.target.value)) {
            if (e.target.value.length <= 10) {
                setMobile(e.target.value)
            }
        }
    }

    return (<Layout>

        {/* <Breadcrumb pageName="Sign Up" pageTitle="Sign Up" /> */}
        <div className="signup-section pt-120 pb-120">
            <ToastContainer/>
            <img alt="image" src="/assets/images/bg/section-bg.png" className="section-bg-top"/>
            <img alt="image" src="/assets/images/bg/section-bg.png" className="section-bg-bottom"/>
            <div className="container">
                <div className="row d-flex justify-content-center">
                    <div className="col-xl-6 col-lg-8 col-md-10">
                        <div className="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div className="form-title">
                                <h3>Sign Up</h3>
                                <p>
                                    Do you already have an account?&nbsp;
                                    <Link href="/login">
                                        <a>Log in here</a>
                                    </Link>
                                </p>
                            </div>
                            {/* Display Loading Screen Here */}
                            {isLoaded ? (<Preloader classText="preloader"/>) : (<>
                                <form className="w-100" onSubmit={Register}>
                                    <div className="row">
                                        <div className="col-md-6">
                                            <div className="form-inner">
                                                <label>First Name <b className="text-danger">*</b></label>
                                                <input type="text" placeholder="John" onChange={(event) => {
                                                    setFirstName(event.target.value)
                                                }} value={firstName} required={true}/>
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="form-inner">
                                                <label>Last Name <b className="text-danger">*</b></label>
                                                <input type="text" placeholder="Doe" onChange={(event) => {
                                                    setLastName(event.target.value)
                                                }} value={lastName} required={true}/>
                                            </div>
                                        </div>
                                        <div className="col-md-12">
                                            <div className="form-inner">
                                                <label>Enter Your Email <b className="text-danger">*</b></label>
                                                <input type="email" placeholder="Enter Your Email"
                                                       onChange={(event) => {
                                                           setEmail(event.target.value)
                                                       }} value={email} required={true}/>
                                            </div>
                                        </div>
                                        <div className="col-md-12">
                                            <div className="form-inner">
                                                <label>Enter your Username <b className="text-danger">*</b></label>
                                                <input type="tel" placeholder="@johndoe11" onChange={(event) => {
                                                    setUserName(event.target.value)
                                                }} value={userName} required={true}/>
                                            </div>
                                        </div>
                                        <div className="col-md-12">
                                            <div className="form-inner">
                                                <label>Enter Your Mobile</label>
                                                <input type="tel" placeholder="819 555 5555" onChange={(event) => {
                                                    validateMobile(event)
                                                }} value={mobile} max="10"/>
                                            </div>
                                        </div>
                                        <div className="col-md-12">
                                            <div className="form-inner">
                                                <label>Password <b className="text-danger">*</b></label>
                                                <input type={openEye === 1 ? "text" : "password"} id="password"
                                                       placeholder="Create A Password" onChange={(event) => {
                                                    setPassword(event.target.value)
                                                }} value={passWord}/>
                                                <i className={openEye === 1 ? "bi bi-eye-slash bi-eye" : "bi bi-eye-slash"}
                                                   id="togglePassword"
                                                   onClick={handleEyeIcon}
                                                   required={true}/>
                                            </div>
                                        </div>
                                        <div className="col-md-12">
                                            <div className="form-inner">
                                                <label>Address </label>
                                                <input type="text" className="mb-1" onChange={(event) => {
                                                    setStreet(event.target.value)
                                                }} placeholder="Street Address" value={street}/>
                                                <input type="text" className="mb-1" onChange={(event) => {
                                                    setCity(event.target.value)
                                                }} placeholder="Enter your City" value={city}/>
                                                <input type="text" className="mb-1" onChange={(event) => {
                                                    setState(event.target.value)
                                                }} placeholder="Enter your State" value={state}/>
                                                <input type="text" className="mb-1" value={country}
                                                       readOnly={true}/>
                                                <input type="text" className="mb-1" onChange={(event) => {
                                                    setZipCode(event.target.value)
                                                }} placeholder="Enter your  Postal code" value={zipCode}/>
                                            </div>
                                        </div>

                                        {/* <div className="col-md-12">
                        <div className="form-inner">
                          <label>How did you here about us*</label>
                          <select defaultValue={"none"} className="form-control rounded-0" onChange={(event) => { setHereAboutUs(event.target.value) }} >
                            <option value="">select value from List</option>
                            <option value="email-or-newsletr">Email or News lates</option>
                            <option value="outdoor-advertisement">Out door advertisement</option>
                            <option value="google-search">Google Search</option>
                            <option value="kijiji">kijiji</option>
                            <option value="word-of-mouth">Word of Mouth</option>
                            <option value="facebook">Facebook</option>
                            <option value="walk-in">Walk in</option>
                          </select>
                        </div>
                      </div> */}
                                        {/* <div className="col-md-12">
                        <div className="form-agreement form-inner d-flex justify-content-between flex-wrap">
                          <div className="form-group">
                            <label htmlFor="html">
                              By Registering your account on Bis2Cart we are assuming that you have reade our <Link href="/terms">Terms & Conditions</Link> and <Link href="/policy">Privacy Policy</Link>
                            </label>
                          </div>
                        </div>
                      </div> */}
                                    </div>
                                    <button type="submit" className="account-btn">Create Account</button>
                                </form>
                            </>)}
                            {/* Loading Display Ends Here */}

                            <div className="alternate-signup-box">
                                <h6>or signup WITH</h6>
                                <div className="btn-group gap-4">
                                    <div className="btn-group gap-4">
                                        <GoogleOAuthProvider clientId={process.env.NEXT_PUBLIC_GOOGLE_CLIENT_ID}>
                                            <GoogleLogin
                                                onSuccess={(response) => {
                                                    // console.log(response);
                                                    decode(response.credential)
                                                }}
                                                onError={(response) => {
                                                    console.log(response)
                                                    toast.error("Google Login Failed");
                                                }}
                                            />
                                        </GoogleOAuthProvider>
                                        {/* <FacebookConnect appId={process.env.NEXT_PUBLIC_FACEBOOK_APP_ID}
                        fields='name,email,picture'
                        callback={callbackHandler}
                        xfbml buttonSize='medium'
                        variant='primary'
                        buttonText='Sign in with Facebook'
                      /> */}
                                    </div>
                                </div>
                            </div>
                            <div className="form-poicy-area">
                                <p>By clicking the <b>signup</b> button, you create a <b>Bid2Cart </b> account, and
                                    you agree to <i><b>Bid2Carts </b></i>
                                    <Link href="/terms">Terms &amp; Conditions</Link>&nbsp;&amp;&nbsp;
                                    <Link href="/policy">Privacy Policy</Link>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>);
}

export default SignupPage;
