import BannerHead from '@/Components/Banners/BannerHead'
import TitleSection from '@/Components/TitleSection'
import Layout from '@/Layouts/Layout'
import { Head } from '@inertiajs/react'
import React from 'react'

import Section1AboutUs from './Section1AboutUs'

import Section3AboutUs from './Section3AboutUs'
import Section4AboutUs from './Section4AboutUs'
import AppointmentsSection from '@/Components/Sections/AppointmentsSection'
import DoctorsListSection from '@/Components/Sections/DoctorsListSection'
import VideoSectionAboutUs from './VideoSectionAboutUs'

const AboutUs = ({ page = [], doctor, doctors }) => {
    return (
        <Layout>
            <Head title={page.title}></Head>
            <BannerHead title={page.title} breadcrumb={[
                {
                    title: page.title
                }
            ]} />
            <Section1AboutUs doctor={doctor} />
            <VideoSectionAboutUs />
            <Section3AboutUs />
            <Section4AboutUs />
            <AppointmentsSection />
            <DoctorsListSection doctors={doctors} />
        </Layout>
    )
}

export default AboutUs
