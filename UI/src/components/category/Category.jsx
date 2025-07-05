import React, {useEffect, useState} from 'react';
import Link from 'next/link';
import Image from 'next/image';
import Fade from 'react-reveal/Fade';
import Preloader from '../common/Preloader';

export default function Category(props) {
    const [item, setItem] = useState([]);
    const [isLoaded, setIsLoaded] = useState(true)

    useEffect(() => {
        getCategory().then(r => setIsLoaded(false));
    }, [props])

    // Function to get Category 
    async function getCategory() {
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/categories`);
        const data = await res.json();
        // console.log(data)
        setItem(data);
        setIsLoaded(false)

    }
    // Custom image loader 
    const customImageLoader = ({src}) => {
        return src;
    }
    return <>{item && item.map(props => {
        return <>{isLoaded ? (
            <Preloader classText="preloader"/>
        ) : (
            <div key={props.cat_id} className='m-1 p-2 category-card wow animate fadeInDown' data-wow-duration="1500ms"
                 data-wow-delay="200ms">
                <Fade cascade>
                    <Image loader={customImageLoader} alt="image" src={props.category_thumbnail} width={50}
                           height={50}/>
                    <Link className='m-1 p-1 text-right fw-bold' href={`/category/${props.category_name}`}>
                        {props.category_name}
                    </Link>
                </Fade>
            </div>
        )}
        </>
    })}
    </>
}

