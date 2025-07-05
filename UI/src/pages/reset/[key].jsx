import React, {useEffect, useState} from "react";
import {ToastContainer} from 'react-toastify';
import Router, {useRouter} from 'next/router';
import Preloader from "../../components/common/Preloader";
import Layout from "../../components/layout/Layout";

function ForgotPassword() {
    const [openEye, setOpenEye] = useState();
    const [openConfirmEye, setOpenConfirmEye] = useState();
    const [isLoaded, setIsLoaded] = useState(true)
    const [password, setPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const router = useRouter()
    const {key} = router.query

    useEffect(() => {
        // If user is logged in can not access this page 
        if (sessionStorage.getItem('token')) {
            Router.push('/dashboard').then(r => setIsLoaded(false))
        }
        setIsLoaded(false)
    }, [])

    // Sending response to server to send password reset mail to given email address 
    const resetPassword = async (e) => {
        e.preventDefault();

        if (password !== confirmPassword) {
            toast.error('Confirm password and Password are not same');
        }
        // `${process.env.NEXT_PUBLIC_API_URL}/api/auth/verify?mail_hash=${mail_hash}`
        // Sending Password Reset 
        let headersList = {
            "Accept": "application/json",
            "Content-Type": "application/json"
        }

        let bodyContent = JSON.stringify({
            "key": key,
            "password": password,
            "confirm_password": confirmPassword
        });

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/auth/change/password`, {
            method: "POST",
            body: bodyContent,
            headers: headersList
        });

        let data = await response.json();
        // console.log(data);
        if (data.status === true) {
            toast.success(data.msg)
            setTimeout(() => {
                Router.push('/login')
            }, 5000);

        } else {
            toast.error(data.msg)
        }
    }

    // Password Show Hide
    const handleEyeIcon = () => {
        if (openEye === false || openEye === 0) {
            setOpenEye(1);
        } else {
            setOpenEye(false);
        }
    };

    // Confirm Password Show Hide
    const handleConfirmEyeIcon = () => {
        if (openConfirmEye === false || openConfirmEye === 0) {
            setOpenConfirmEye(1);
        } else {
            setOpenConfirmEye(false);
        }
    };

    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (<Layout>
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
                                        <h3>Reset Your Password</h3>
                                    </div>
                                    <form className="w-100" onSubmit={resetPassword}>
                                        <div className="col-12">
                                            <div className="form-inner">
                                                <label>Enter Password *</label>
                                                <input type={openEye === 1 ? "text" : "password"} onChange={(event) => {
                                                    setPassword(event.target.value)
                                                }} value={password} required={true} placeholder="Create A Password"/>
                                                <i className={
                                                    openEye === 1
                                                        ? "bi bi-eye-slash bi-eye"
                                                        : "bi bi-eye-slash"
                                                }
                                                   id="togglePassword"
                                                   onClick={handleEyeIcon}
                                                />
                                            </div>
                                        </div>
                                        <div className="col-12">
                                            <div className="form-inner">
                                                <label>Confirm Password *</label>
                                                <input type={openConfirmEye === 1 ? "text" : "password"}
                                                       onChange={(event) => {
                                                           setConfirmPassword(event.target.value)
                                                       }} value={confirmPassword} required={true}
                                                       placeholder="Create A Password"
                                                />
                                                <i className={
                                                    openConfirmEye === 1
                                                        ? "bi bi-eye-slash bi-eye"
                                                        : "bi bi-eye-slash"
                                                }
                                                   id="toggleConfirmPassword"
                                                   onClick={handleConfirmEyeIcon}
                                                />
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
        </>
    );
}

export default ForgotPassword