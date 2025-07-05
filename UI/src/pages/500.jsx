import React, {useEffect, useState} from "react";
import Preloader from "../components/common/Preloader";

function CustomError() {
    const [isLoaded, setIsLoaded] = useState(true);
    useEffect(() => {
        setIsLoaded(false);
    }, []);
    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (
                <div className="error-section pt-120 pb-120">
                    <img
                        src="/assets/images/bg/section-bg.png"
                        className="img-fluid section-bg-top"
                        alt=""
                    />
                    <img
                        src="/assets/images/bg/section-bg.png"
                        className="img-fluid section-bg-bottom"
                        alt=""
                    />
                    <img
                        src="/assets/images/bg/e-vector1.svg"
                        className="evector1"
                        alt=""
                    />
                    <img
                        src="/assets/images/bg/e-vector2.svg"
                        className="evector2"
                        alt=""
                    />
                    <img
                        src="/assets/images/bg/e-vector3.svg"
                        className="evector3"
                        alt=""
                    />
                    <img
                        src="/assets/images/bg/e-vector4.svg"
                        className="evector4"
                        alt=""
                    />
                    <div className="">
                        <div className="row d-flex justify-content-center g-4">
                            <div className="col-lg-6 col-md-8 text-center">
                                <div className="error-wrapper">
                                    <img
                                        src="/assets/images/bg/500.webp"
                                        className="error-bg img-fluid"
                                        alt="error-bg"
                                    />
                                    <div
                                        className="error-content wow fadeInDown"
                                        data-wow-duration="1.5s"
                                        data-wow-delay=".2s"
                                    >
                                        <h2>Well, This is embarrassing...</h2>
                                        <h4>
                                            Sorry, this is not working properly. we know about this
                                            mistake and are working to fix it.
                                        </h4>
                                        <p className="para">
                                            In the meantime, here is what you can do:{" "}
                                        </p>
                                        <p className="para">
                                            <i className="bx bx-sm bx-refresh"></i>{" "}
                                            <strong>Refresh the page</strong>(sometimes this helps){" "}
                                            <br/>
                                            <i className="bx bx-sm bxs-time"></i>{" "}
                                            <strong>Try again</strong> in 30 minutes <br/>
                                            <i className="bx bx-sm bx-envelope"></i>
                                            <strong>Email us </strong> at contact@mail.com and tell us
                                            what happened. <br/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}

export default CustomError;

{
    /* <>
    {isLoaded ? (
      <Preloader classText="preloader" />
    ) : (<> </>)}
  </> */
}
