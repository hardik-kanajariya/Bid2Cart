import Link from "next/link";
import React, {useEffect, useState} from "react";
import Preloader from "../components/common/Preloader";

function CustomError() {
    const [isLoaded, setIsLoaded] = useState(true)
    useEffect(() => {
        setIsLoaded(false)
    }, [])
    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (<div className="error-section pt-120 pb-120">
                <img src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-top" alt=""/>
                <img src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-bottom" alt=""/>
                <img src="/assets/images/bg/e-vector1.svg" className="evector1" alt=""/>
                <img src="/assets/images/bg/e-vector2.svg" className="evector2" alt=""/>
                <img src="/assets/images/bg/e-vector3.svg" className="evector3" alt=""/>
                <img src="/assets/images/bg/e-vector4.svg" className="evector4" alt=""/>
                <div className="container">
                    <div className="row d-flex justify-content-center g-4">
                        <div className="col-lg-6 col-md-8 text-center">
                            <div className="error-wrapper">
                                <img src="/assets/images/bg/error-bg.png" className="error-bg img-fluid"
                                     alt="error-bg"/>
                                <div className="error-content wow fadeInDown" data-wow-duration="1.5s"
                                     data-wow-delay=".2s">
                                    <h2>Sorry we can’t find that page</h2>
                                    <p className="para">
                                        The page you are looking for was moved, removed, renamed or
                                        never existed
                                    </p>
                                    <Link href="/">
                                        <a className="eg-btn btn--primary btn--md">Back Home</a>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>)}
        </>
    );
}

export default CustomError;

{/* <>
  {isLoaded ? (
    <Preloader classText="preloader" />
  ) : (<> </>)}
</> */
}