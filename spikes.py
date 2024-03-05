import pyshark

def capture_live_packets(network_interface=None):
    if network_interface != None:
        with pyshark.LiveCapture(interface=network_interface, tshark_path="/usr/bin/tshark") as capture:
            for raw_packet in capture.sniff_continuously():
                if raw_packet.transport_layer != None and isinstance(raw_packet.transport_layer, str) and raw_packet.transport_layer in raw_packet:
                    yield {
                        "transport_layer": raw_packet.transport_layer,
                        raw_packet.transport_layer: raw_packet[raw_packet.transport_layer]._all_fields
                    }

for packet in capture_live_packets(network_interface="wlo1"):
    for key, val in packet[packet["transport_layer"]].items():
        print(f'Key : {key}\nValue : {val}')
    print("\n\n")