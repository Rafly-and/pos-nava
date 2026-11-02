export default function ApplicationLogo({ className = "", ...props }) {
    return (
        <svg {...props} className={className} viewBox="0 0 240 240" role="img" aria-label="NAVA Hardware" xmlns="http://www.w3.org/2000/svg">
            <rect x="12" y="12" width="216" height="216" rx="34" fill="#25292B" />
            <path d="M55 174V66h17l49 69V66h18v108h-17L73 105v69H55Z" fill="#F4F1EB" />
            <path d="M150 174 186 66h18l-36 108h-18Z" fill="#A68C68" />
            <path d="M156 153h44" stroke="#A68C68" strokeWidth="5" strokeLinecap="square" />
        </svg>
    );
}
