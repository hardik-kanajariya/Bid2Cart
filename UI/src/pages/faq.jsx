import React, {useEffect, useState} from "react";
import Breadcrumb from "../components/common/Breadcrumb";
import Preloader from "../components/common/Preloader";
import FaqAccordion from "../components/faq/FaqAccordion";
import Layout from "../components/layout/Layout";

function FaqPage() {
    const [isLoaded, setIsLoaded] = useState(true)
    useEffect(() => {
        setIsLoaded(false)
    }, [])
    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (<Layout>
                <Breadcrumb pageTitle="Faq" pageName="Faq"/>
                <div className="faq-section pt-120 pb-120">
                    <div className="container">
                        <div className="row d-flex justify-content-center gy-5">
                            <FaqAccordion/>
                        </div>
                    </div>
                </div>
            </Layout>)}
        </>
    );
}

export default FaqPage;
