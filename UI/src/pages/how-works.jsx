import React, {useEffect, useState} from "react";
import Breadcrumb from "../components/common/Breadcrumb";
import Preloader from "../components/common/Preloader";
import HowItWork from "../components/howItWork/HowItWork";
import WhyChooseUs from "../components/howItWork/WhyChooseUs";
import Layout from "../components/layout/Layout";

function HowWorksPage() {
    const [isLoaded, setIsLoaded] = useState(true)
    useEffect(() => {
        setIsLoaded(false)
    }, [])
    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (<Layout>
                <Breadcrumb pageTitle="How It Works" pageName="How It Works"/>
                <HowItWork/>
                <WhyChooseUs/>
            </Layout>)}
        </>
    );
}

export default HowWorksPage;
