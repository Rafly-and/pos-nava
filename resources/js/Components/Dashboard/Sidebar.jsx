import React from "react";
import { usePage } from "@inertiajs/react";
import { IconLayoutGrid } from "@tabler/icons-react";
import LinkItem from "@/Components/Dashboard/LinkItem";
import LinkItemDropdown from "@/Components/Dashboard/LinkItemDropdown";
import Menu from "@/Utils/Menu";

export default function Sidebar({ sidebarOpen }) {
    const { auth, storeProfile, appVersion } = usePage().props;
    const menuNavigation = Menu();

    const storeName = storeProfile?.name || "NAVA Hardware";
    const storeLogo = storeProfile?.logo || null;
    const storeInitial =
        storeName?.charAt(0)?.toUpperCase() ||
        auth?.user?.name?.charAt(0)?.toUpperCase() ||
        "K";

    return (
        <div
            className={`
                ${sidebarOpen ? "translate-x-0 w-[260px]" : "-translate-x-full w-[260px]"}
                md:translate-x-0 ${sidebarOpen ? "md:w-[260px]" : "md:w-[80px]"}
                fixed md:relative inset-y-0 left-0 z-40
                flex h-screen flex-col overflow-hidden md:sticky md:top-0 md:self-stretch md:shrink-0
                border-r border-[#E4DED4] dark:border-[#4B4D4A]
                bg-[#FAF9F6] dark:bg-[#2D3132]
                transition-all duration-300 ease-in-out
            `}
        >
            {/* Logo */}
            <div className="flex items-center h-[76px] px-5 border-b border-[#4B4D4A] bg-[#25292B]">
                {sidebarOpen ? (
                    <div className="flex items-center gap-2">
                        <div className="w-10 h-10 flex items-center justify-center">
                            {storeLogo ? <img src={storeLogo} alt={storeName} className="w-10 h-10 object-contain" /> : <span className="text-[#A68C68] font-extrabold text-xl">N.</span>}
                        </div>
                        <div className="min-w-0">
                            <span className="block text-[17px] font-extrabold tracking-[0.15em] text-[#F4F1EB] truncate">{storeName}</span>
                            <span className="block text-[9px] font-semibold tracking-[0.17em] uppercase text-[#A68C68]">Architectural Hardware</span>
                        </div>
                    </div>
                ) : (
                    <div className="w-9 h-9 flex items-center justify-center rounded-md bg-[#25292B]">
                        {storeLogo ? <img src={storeLogo} alt={storeName} className="w-8 h-8 object-contain" /> : <span className="text-[#A68C68] font-extrabold text-lg">N.</span>}
                    </div>
                )}
            </div>

            {/* Navigation */}
            <nav className="dashboard-scrollbar min-h-0 flex-1 overflow-y-auto py-3">
                {menuNavigation.map((section, index) => {
                    const hasPermission = section.details.some(
                        (detail) => detail.permissions === true
                    );
                    if (!hasPermission) return null;

                    return (
                        <div key={index} className="mb-2">
                            {/* Section Title */}
                            {sidebarOpen && (
                                <div className="px-4 py-2">
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-600">
                                        {section.title}
                                    </span>
                                </div>
                            )}

                            {/* Menu Items */}
                            <div
                                className={
                                    sidebarOpen
                                        ? ""
                                        : "flex flex-col items-center"
                                }
                            >
                                {section.details.map((detail, idx) => {
                                    if (!detail.permissions) return null;

                                    if (detail.hasOwnProperty("subdetails")) {
                                        return (
                                            <LinkItemDropdown
                                                key={idx}
                                                title={detail.title}
                                                icon={detail.icon}
                                                data={detail.subdetails}
                                                access={detail.permissions}
                                                sidebarOpen={sidebarOpen}
                                            />
                                        );
                                    }

                                    return (
                                        <LinkItem
                                            key={idx}
                                            title={detail.title}
                                            icon={detail.icon}
                                            href={detail.href}
                                            access={detail.permissions}
                                            sidebarOpen={sidebarOpen}
                                        />
                                    );
                                })}
                            </div>
                        </div>
                    );
                })}
            </nav>

            {/* Version/Footer */}
            {sidebarOpen && (
                <div className="p-4 border-t border-slate-100 dark:border-slate-800">
                    <p className="text-[10px] text-slate-400 dark:text-slate-600 text-center">
                        NAVA HARDWARE · POS {appVersion}
                    </p>
                </div>
            )}
        </div>
    );
}
