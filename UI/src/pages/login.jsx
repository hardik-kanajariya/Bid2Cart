import Link from "next/link";
import React, {useEffect, useState} from "react";
import Layout from "../components/layout/Layout";
import {toast, ToastContainer} from 'react-toastify';
import Router from "next/router";
import Preloader from "../components/common/Preloader";
import {GoogleLogin, GoogleOAuthProvider} from '@react-oauth/google';
import jwt_decode from "jwt-decode";

function LoginPage() {
    const [openEye, setOpenEye] = useState();
    const [isLoaded, setIsLoaded] = useState(true)

    const handleEyeIcon = () => {
        if (openEye === false || openEye === 0) {
            setOpenEye(1);
        } else {
            setOpenEye(false);
        }
    };

    useEffect(() => {
        if (sessionStorage.getItem('token')) {
            Router.push('/dashboard')
        }
        // console.log(process.env.NEXT_PUBLIC_GOOGLE_CLIENT_ID)
        setIsLoaded(false)
    }, [])


    // Handling Login
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    // Handle Google Login
    async function decode(token) {
        let jwt = await jwt_decode("Bearer " + token);
        if (jwt.email) {
            let headersList = {
                "Accept": "application/json", "Content-Type": "application/json"
            }

            let bodyContent = JSON.stringify({
                "email": jwt.email, "password": jwt.email
            });

            let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/auth/login`, {
                method: "POST", body: bodyContent, headers: headersList
            });

            let data = await response.json();
            // console.log(data);

            if (data.status === true) {
                sessionStorage.setItem('token', data.token)
                sessionStorage.setItem('username', data.username)
                // Redirecting user to dashboard page
                if (sessionStorage.getItem('token')) {
                    await await Router.push('/dashboard')
                }
            } else {
                toast.error(data.message)
            }
        } else {
            toast.warning("Something went wrong please try again after some time")
        }
    }

    // Handle Form Login
    const Login = async (e) => {
        e.preventDefault();

        // using Fetch API
        let headersList = {
            "Accept": "application/json", "Content-Type": "application/json"
        }

        let bodyContent = JSON.stringify({
            "email": email, "password": password
        });

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/auth/login`, {
            method: "POST", body: bodyContent, headers: headersList
        });

        let data = await response.json();
        // console.log(data);

        if (data.status === true) {
            sessionStorage.setItem('token', data.token)
            sessionStorage.setItem('username', data.username)
            // Redirecting user to dashboard page
            if (sessionStorage.getItem('token')) {
                await await Router.push('/dashboard')
            }
        } else {
            toast.error(data.message)
        }
    }

    // handle Facebook Login
    async function callbackHandler(result) {
        // console.log(typeof (result))
        if (typeof (result) == 'string') {
            // console.log("result is defined")
            // console.log(result)
        } else {
            let headersList = {
                "Accept": "application/json", "Content-Type": "application/json"
            }

            let bodyContent = JSON.stringify({
                "email": result.facebookUserInfo.email, "password": result.facebookUserInfo.email
            });

            let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/auth/login`, {
                method: "POST", body: bodyContent, headers: headersList
            });

            let data = await response.json();
            // console.log(data);

            if (data.status === true) {
                sessionStorage.setItem('token', data.token)
                sessionStorage.setItem('username', data.username)
                // Redirecting user to dashboard page
                if (sessionStorage.getItem('token')) {
                    await await Router.push('/dashboard')
                }
            } else {
                toast.error(data.message)
            }
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
                                        <h3>Log In</h3>
                                        <p>
                                            New Member?{" "}
                                            <Link href="/signup">
                                                <a>signup here</a>
                                            </Link>
                                        </p>
                                    </div>
                                    <form className="w-100" onSubmit={Login}>
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
                                            <div className="col-12">
                                                <div className="form-inner">
                                                    <label>Password *</label>
                                                    <input type={openEye === 1 ? "text" : "password"}
                                                           onChange={(event) => {
                                                               setPassword(event.target.value)
                                                           }} value={password} required={true}
                                                           placeholder="Create A Password"/>
                                                    <i className={openEye === 1 ? "bi bi-eye-slash bi-eye" : "bi bi-eye-slash"}
                                                       id="togglePassword"
                                                       onClick={handleEyeIcon}
                                                    />
                                                </div>
                                            </div>
                                            <div className="col-12">
                                                <div
                                                    className="form-agreement form-inner d-flex justify-content-between flex-wrap">
                                                    <Link href="/forgot-password">
                                                        <span className="text-decoration-underline cursor-pointer">Forgotten Password</span>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                        <button className="account-btn">Log in</button>
                                    </form>
                                    <div className="alternate-signup-box">
                                        <h6>or signup WITH</h6>
                                        <div className="btn-group gap-4">

                                            <GoogleOAuthProvider clientId={process.env.NEXT_PUBLIC_GOOGLE_CLIENT_ID}>
                                                <GoogleLogin
                                                    onSuccess={(response) => {
                                                        // console.log(response);
                                                        decode(response.credential)
                                                    }}
                                                    onError={(response) => {
                                                        // console.log(response)
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
                            </div>
                        </div>
                    </div>
                </div>
            </Layout>)}
        </>);
}

export default LoginPage;
