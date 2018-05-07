<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 07.05.18
 * Time: 10:30
 */

namespace App\Libaries;

define("SOL_IP", 0);
define("IP_TTL", 2);    // On OSX, use '4' instead of '2'.
class Traceroute
{

    /*
    This is free and unencumbered software released into the public domain.
    Anyone is free to copy, modify, publish, use, compile, sell, or
    distribute this software, either in source code form or as a compiled
    binary, for any purpose, commercial or non-commercial, and by any
    means.
    In jurisdictions that recognize copyright laws, the author or authors
    of this software dedicate any and all copyright interest in the
    software to the public domain. We make this dedication for the benefit
    of the public at large and to the detriment of our heirs and
    successors. We intend this dedication to be an overt act of
    relinquishment in perpetuity of all present and future rights to this
    software under copyright law.
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
    IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
    OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
    ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
    OTHER DEALINGS IN THE SOFTWARE.
    For more information, please refer to [http://unlicense.org]
    */


    protected $maximum_hops = 30;

    protected $port = 33434;  // Standard port that traceroute programs use. Could be anything actually.

    public function trace($dest_url)
    {
// Get IP from URL
        $dest_addr = gethostbyname($dest_url);
        print "Tracerouting to destination: $dest_addr\n";
        $ttl = 1;
        while ($ttl < $this->maximum_hops) {
            // Create ICMP and UDP sockets
            $recv_socket = socket_create(AF_INET, SOCK_RAW, getprotobyname('icmp'));
            $send_socket = socket_create(AF_INET, SOCK_DGRAM, getprotobyname('udp'));
            echo "T";
            // Set TTL to current lifetime
            socket_set_option($send_socket, SOL_IP, IP_TTL, $ttl);
            // Bind receiving ICMP socket to default IP (no port needed since it's ICMP)
            socket_bind($recv_socket, 0, 0);
            // Save the current time for roundtrip calculation
            $t1 = microtime(true);
            // Send a zero sized UDP packet towards the destination
            socket_sendto($send_socket, "", 0, 0, $dest_addr, $this->port);
            // Wait for an event to occur on the socket or timeout after 5 seconds. This will take care of the
            // hanging when no data is received (packet is dropped silently for example)
            $r = [$recv_socket];
            $w = $e = [];
            socket_select($r, $w, $e, 5, 0);
            // Nothing to read, which means a timeout has occurred.
            if (count($r)) {
                // Receive data from socket (and fetch destination address from where this data was found)
                socket_recvfrom($recv_socket, $buf, 512, 0, $recv_addr, $recv_port);
                // Calculate the roundtrip time
                $roundtrip_time = (microtime(true) - $t1) * 1000;
                // No decent address found, display a * instead
                if (empty ($recv_addr)) {
                    $recv_addr = "*";
                    $recv_name = "*";
                } else {
                    // Otherwise, fetch the hostname and geoinfo for the address found
                    $recv_name = gethostbyaddr($recv_addr);
                }

                printf("%3d   %-15s  %.3f ms  %s\n", $ttl, $recv_addr, $roundtrip_time, $recv_name);

            } else {
                // A timeout has occurred, display a timeout
                printf("%3d   (timeout)\n", $ttl);
            }
            // Close sockets
            socket_close($recv_socket);
            socket_close($send_socket);
            // Increase TTL so we can fetch the next hop
            $ttl++;
            // When we have hit our destination, stop the traceroute
            if ($recv_addr == $dest_addr) break;
        }
    }

}